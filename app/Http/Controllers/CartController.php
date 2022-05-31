<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function store(Request $request) {
        // Validate 
        $validator = Validator::make($request->all(), [
        	// User input
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'category' => 'required|string|max:255',
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
        	$product = [
        		'id' => $request->id,
        		'name' => $request->name,
        		'price' => $request->price,
        		'category' => $request->category,
        		'size' => $request->size,
        		'color' => $request->color,
        		'image' => $request->image,
        		'inStock' => true
        	];

        	$products = [];

        	if(session('products')) {
        		$products = session('products');
	        	// Check if item is in cart here
				if($this->checkForItemInCart($request->id, $request->size, $request->color) === false) {
					$products[] = $product;
				}	
        	} else {
        		$products[] = $product;
        	}

			session([
				'products' => $products
			]);

	        return response()->json([
	            'message' => 'success'
	        ]);
	    }
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
}
