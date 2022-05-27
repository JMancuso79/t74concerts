<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function store(Request $request) {
    	$products = [];
    	$products[] = [
			'product' => $request->product,
			'selectedColor' => $request->selectedColor,
			'selectedSize' => $request->selectedSize
		];
		session([
			'products' => $products
		]);

        return response()->json([
            'message' => 'success'
        ]);  
    }
}
