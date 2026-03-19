<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\Customer\CustomerStoreRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;

class CustomerController extends Controller
{

    public function index()
    {
        return Customer::latest()->get();
    }
    public function store(CustomerStoreRequest $request)
    {
        $customer = Customer::create($request->validated());
        return new CustomerResource($customer);
    }
    public function show(Customer $customer)
    {
        return $customer;
    }
    public function update(CustomerUpdateRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return new CustomerResource($customer);
    }
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->noContent();
    }
}
