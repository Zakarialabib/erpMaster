<?php

namespace app\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends BaseController
{
    /**
     * Retrieve a list of Customer with optional filters and pagination.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function index(Request $request)
    {
        try {
            $query = Customer::query();

            if ($request->has('_end')) {
                $limit = $request->input('_end', 10);
                $offset = $request->input('_start', 0);
                $order = $request->input('_order', 'asc');
                $sort = $request->input('_sort', 'id');

                $query->when($request->filled('user_id'), function ($q) use ($request) {
                    return $q->where('user_id', $request->input('user_id'));
                });

                $query->orderBy($sort, $order)->offset($offset)->limit($limit);
            }

            $customers = $query->get();
            $customerResource = CustomerResource::collection($customers);

            return $this->sendResponse($customerResource, __('Customer List'), count($customers));
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
            $customer = Customer::create($input);
            DB::commit();
            return $this->sendResponse($customer, 'Customer created successfully');
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
            $customer = new CustomerResource(Customer::find($id));
            if (is_null($customer)) {
                return $this->sendError('Customer not found');
            } else {
                return $this->sendResponse($customer, 'Customer retrieved successfully');
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
        $Customer = Customer::findOrFail($id);
        $Customer->update($request->all());

        return new CustomerResource($Customer);
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
            $Customer = Customer::findOrFail($id);
            $Customer->delete();
            return $this->sendResponse($Customer, 'Customer deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
    }
}
