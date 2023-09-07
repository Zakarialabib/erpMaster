<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function show(Product $id)
    {
        $product = Product::findorfail($id);

        return view('front.product', ['product' => $product]);
    }
}
