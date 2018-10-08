<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    //
    public function getAll () {
    	$product = Product::with('category')->with('sales')->get();
    	return $product;
    }
}
