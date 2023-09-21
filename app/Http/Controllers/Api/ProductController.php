<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): ProductCollection
    {
        return new ProductCollection(Product::with('category')->get());
    }

    /** Store a newly created resource in storage. */
    public function store(Request $request): ProductResource
    {
        $product = Product::create([
            'id'    => $request->id,
            'name'  => $request->name,
            'price' => $request->price,

        ]);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     */
    public function update(Request $request, $id): void
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     */
    public function destroy($id): void
    {
    }
}
