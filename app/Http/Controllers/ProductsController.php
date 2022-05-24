<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;

        $product->name = $request->name;
        $product->key = 't74-'.rand().'-'.rand();
        $product->slug = $request->slug.'-'.rand();
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->inventory = $request->inventory;
        $product->sizes = $request->sizes;
        $product->colors = $request->colors;
        $product->price = $request->price;
        $product->tags = $request->tags;
        $product->category = $request->category;
        $product->status = $request->status;
        $product->featured = $request->featured;
        $product->concert_id = $request->concert_id;
        $product->save();

        if($request->images) {
            $this->storeProductImages($product->id, $request->images);
            $this->updateFeaturedImage($product->id);
        }

        return response()->json([
            'message' => 'success',
            'product' => $product,
            'errors' => [],
        ]);
    }

    public function updateFeaturedImage($product_id) {
        $product = Product::where('id', $product_id)->first();
        if($product) {
            $product_image = ProductImage::where('product_id', $product_id)->where('featured', 1)->first();
            $product->image = $product_image->filepath;

            $product->save();
        }
    }

    public function storeProductImages($id, $images) {
        $images_to_delete = ProductImage::where('product_id', $id)->get();
        if($images_to_delete) {
            foreach ($images_to_delete as $image_to_delete) {
                $image_to_delete->delete();
            }
        }

        if($images) {
            foreach ($images as $image) {
                $img = new ProductImage;

                $img->product_id = $id;
                $img->filepath = $image['filepath'];
                $img->featured = $image['featured'];

                $img->save();
            }
        }
        return;
    }

    public function manageProductsList() {
        $products = Product::orderBy('created_at', 'DESC')->get();
        if($products) {
            foreach ($products as $product) {
                $product->images = ProductImage::where('product_id', $product->id)->get();
            }
        }
        return $products;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->first();
        if($product) {
            $product->images = ProductImage::where('product_id', $product->id)->get(); 
        }
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();

        if($product) {
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->inventory = $request->inventory;
            $product->sizes = $request->sizes;
            $product->colors = $request->colors;
            $product->price = $request->price;
            $product->tags = $request->tags;
            $product->category = $request->category;
            $product->status = $request->status;
            $product->featured = $request->featured;
            $product->save();

            if($request->images) {
                $this->storeProductImages($product->id, $request->images);
                $this->updateFeaturedImage($product->id);
            }

            return response()->json([
                'message' => 'success',
                'product' => $product,
                'errors' => [],
            ]);
        } else {
            return response()->json([
                'message' => 'fail',
                'product' => [],
                'errors' => ['Something went wrong'],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $images_to_delete = ProductImage::where('product_id', $id)->get();
        if($images_to_delete) {
            foreach ($images_to_delete as $image_to_delete) {
                $image_to_delete->delete();
            }
        }

        $product_to_delete = Product::where('id', $id)->first();
        if($product_to_delete) {
            $product_to_delete->delete(); 
            return response()->json([
                'message' => 'success',
                'errors' => [],
            ]);
        } else {
            return response()->json([
                'message' => 'fail',
                'product' => [],
                'errors' => ['Something went wrong'],
            ]);
        }
    }
}
