<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductController extends BaseController
{
    /**
     * Retrieve a list of products with optional filters and pagination.
     *
     * @param  Request  $request
     *
     */
    public function index(Request $request)
    {
        try {
            $query = Product::query();

            // Pagination
            if ($request->has('_limit')) {
                $limit = $request->input('_limit', 10);
                $offset = $request->input('_offset', 0);
                $query->skip($offset)->take($limit);
            }

            // Sorting
            if ($request->has('_sort')) {
                $sortField = $request->input('_sort', 'name');
                $sortOrder = $request->input('_order', 'asc');
                $query->orderBy($sortField, $sortOrder);
            }

            // Filtering by brand_id
            if ($request->filled('brand_id')) {
                $query->where('brand_id', $request->input('brand_id'));
            }

            // Filtering by availability
            if ($request->has('available')) {
                $query->whereHas('warehouses', function ($q) {
                    $q->where('qty', '>', 0);
                });
            }

            // Eager loading relationships
            $query->with(['category', 'brand', 'warehouses']);

            // Get filtered and paginated products
            $products = $query->get();
            $productsResource = ProductResource::collection($products);

            return $this->sendResponse($productsResource, 'Product List', count($products));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
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
        } catch (Exception $e) {
            DB::rollback();

            return $this->sendError($e->getMessage());
        }
    }
}
