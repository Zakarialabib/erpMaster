<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderController extends BaseController
{
    /**
     * Retrieve a list of orders with optional filters and pagination.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $query = Order::with(['customer', 'user']);

            if ($request->has('_end')) {
                $limit = $request->input('_end', 10);
                $offset = $request->input('_start', 0);
                $order = $request->input('_order', 'asc');
                $sort = $request->input('_sort', 'id');

                $query->when($request->filled('customer_id'), function ($q) use ($request) {
                    return $q->where('customer_id', $request->input('customer_id'));
                });

                $query->when($request->filled('user_id'), function ($q) use ($request) {
                    return $q->where('user_id', $request->input('user_id'));
                });

                $query->orderBy($sort, $order)->offset($offset)->limit($limit);
            }

            $orders = $query->get();
            $ordersResource = OrderResource::collection($orders);

            return $this->sendResponse($ordersResource, __('Order List'), count($orders));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $input = $request->all();
            $order = Order::create($input);
            DB::commit();

            return $this->sendResponse($order, 'Order created successfully');
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $order = new OrderResource(Order::find($id));

            if ( ! $order) {
                return $this->sendError('Order not found');
            }

            return $this->sendResponse($order, 'Order retrieved successfully');
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->update($request->all());

            return $this->sendResponse(new OrderResource($order), 'Order updated successfully');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();

            return $this->sendResponse($order, 'Order deleted successfully');
        } catch (Exception $e) {
            DB::rollback();

            return $this->sendError($e->getMessage());
        }
    }
}
