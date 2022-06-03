<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function addProductToCart(Request $request) {
        // Validate 
        $validator = Validator::make($request->all(), [
        	// User input
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'color' => 'required|string|max:255',
        ]); 
        // Validation Error
        if ($validator->fails()) {
        // If Validation Fails
            return response()->json([
                'message' => 'fail-validation',
                'errors' => $validator->errors()->first()
            ]);
        } 
        // Validation passes
        else {
        	// Set products
        	$products = $this->setProducts();
        	// Cart is not empty
        	if(!empty($products)) {
        		// Product is not in cart
        		if($this->checkForItemInCart($request->id, $request->size, $request->color) === false) {
        			$products[] = $this->doProduct($request, null);
        		} else {
        			$quantity = $this->getProductQuantity($request->id, $request->size, $request->color);
        			$quantity = $quantity + 1;
 					$products = $this->updateQuantity($request, $quantity, $products);
        		}
        	} 
        	// Add product to empty cart
        	else {
        		$products[] = $this->doProduct($request, null);
        	}

        	// Update Cart
			session([
				'products' => $products
			]);

	        return response()->json([
	            'message' => 'success',
	            'products' => $products
	        ]);
	    }
    }

    public function setProducts() {
    	$products = [];
    	if((session('products')) && (!empty(session('products')))) {
    		$products = session('products');
    	}
    	return $products;
    }

    public function doProduct($data, $quantity) {
    	if($quantity == null) {
    		$quantity = 1;
    	}
		$product = [
    		'id' => $data->id,
    		'name' => $data->name,
    		'price' => $data->price,
    		'category' => $data->category,
    		'size' => $data->size,
    		'color' => $data->color,
    		'image' => $data->image,
    		'inStock' => true,
    		'quantity' => $quantity
    	];
    	return $product;
    }

    public function checkForItemInCart($id, $size, $color) {
    	$isInCart = false;
    	$products = session('products');

		foreach ($products as $p) {
			// Item ID is in shop
			if($p['id'] === $id) {
				// item is clothing
				if($p['category'] == 'tee-shirt') {
					// If size matches item in cart
					if($p['size'] == $size) {
    					// If color matches item in cart
    					if($p['color'] == $color) {
    						$isInCart = true;
    					}
					}
				}
 			}
		}
   
    	return $isInCart;
    }

    public function getProductQuantity($id, $size, $color) {
    	$products = session('products');
    	$quantity = 0;

		foreach ($products as $p) {
			// Item ID is in shop
			if($p['id'] === $id) {
				// item is clothing
				if($p['category'] == 'tee-shirt') {
					// If size matches item in cart
					if($p['size'] == $size) {
    					// If color matches item in cart
    					if($p['color'] == $color) {
    						$quantity =  $p['quantity'];
    					}
					}
				}
 			}
		}
		return $quantity;
    }

    public function destroy(Request $request) {
    	if(session('products')) {
    		$products = [];
    		$oldProducts = session('products');

    		foreach ($oldProducts as $p) {
    			// If this item has the same ID as the request ID
    			if($p['id'] == $request->id) {
    				// If this item is the same size as the request size
    				if($p['size'] == $request->size) {
	    				// If this item is the same size as the request size
	    				if($p['color'] != $request->color) {
	    					// insert
	    					$products[] = $p;
	    				}
    				} else {
    					// insert
    					$products[] = $p;
    				}
    			} else {
    				// insert
    				$products[] = $p;
    			}
    		}
			session([
				'products' => $products
			]);
    	}
    	return;
    }

    public function update(Request $request) {
    	$products = [];
    	foreach ($request->products as $p) {
			$products[] = [
	    		'id' => $p['id'],
	    		'name' => $p['name'],
	    		'price' => $p['price'],
	    		'category' => $p['category'],
	    		'size' => $p['size'],
	    		'color' => $p['color'],
	    		'image' => $p['image'],
	    		'inStock' => $p['inStock'],
	    		'quantity' => $p['quantity']
	    	];
    	}
		session([
			'products' => $products
		]);
    	return;
    }

    public function updateQuantity($product, $quantity, $products) {
    	$oldProducts = $products;
    	$products = [];
    	foreach ($oldProducts as $p) {
    		// Is this the product?
    		if($product->id == $p['id']) {
    			if($product->size == $p['size']) {
	    			if($product->color == $p['color']) {
	    				$products[] = $this->doProduct($product, $quantity);
	    			} else {
	    				$products[] = $p;
	    			}
    			} else {
    				$products[] = $p;
    			}
    		} else {
    			$products[] = $p;
    		}
    	}
    	return $products;
    }

    public function updateProductQuantity(Request $request) {
    	$oldProducts = $request->products;
    	$product = $request->product;
    	$products = [];
    	foreach ($oldProducts as $p) {
    		// Is this the product?
    		if($product->id == $p->id) {
    			if($product->size == $p->size) {
	    			if($product->color == $p->color) {
	    				$products[] = $this->doProduct($rproduct, $request->quantity);
	    			} else {
	    				$products[] = $p;
	    			}
    			} else {
    				$products[] = $p;
    			}
    		} else {
    			$products[] = $p;
    		}
    	}
		session([
			'products' => $products
		]);
        return response()->json([
            'message' => 'success',
            'products' => $products
        ]);
    }
}
