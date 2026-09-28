<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // !!for show the page
    }

    public function show(Product $product)
    {
        if ($product->status != 'active') {
            abort(404);
        }
        return view('Front.Products.show', compact('product'));
    }
}
