<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{

    /**
     * Retrieve a list of products with optional filters and pagination.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function index(Request $request)
    {
        try {
            $query = Product::query();

            if ($request->has('_end')) {
                $limit = $request->input('_end', 10);
                $offset = $request->input('_start', 0);
                $order = $request->input('_order', 'asc');
                $sort = $request->input('_sort', 'id');

                $query->when($request->filled('brand_id'), function ($q) use ($request) {
                    return $q->where('brand_id', $request->input('brand_id'));
                });

                $query->when($request->has('available'), function ($q) {
                    return $q->whereHas('warehouses', function ($query) {
                        $query->where('qty', '>', 0);
                    });
                });

                $query->with(['category', 'brand'])->orderBy($sort, $order)->offset($offset)->limit($limit);
            }

            $products = $query->get();
            $productsResource = ProductResource::collection($products);

            return $this->sendResponse($productsResource, 'Product List', count($products));
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $product = Product::create($input);
            DB::commit();
            return $this->sendResponse($product, 'Product updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     */
    public function show($id)
    {
        try {
            $product = new ProductResource(Product::find($id));
            if (is_null($product)) {
                return $this->sendError('Product not found');
            } else {
                return $this->sendResponse($product, 'Product retrieved successfully');
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     */
    public function destroy($id)
    {
        try {
            $product = Product::findorFail($id);
            $product->delete();
            return $this->sendResponse($product, 'Product deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
    }
}
