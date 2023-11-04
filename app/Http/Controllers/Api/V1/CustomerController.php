<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CustomerResource;
use App\Http\Resources\v1\CustomerCollection;
use Illuminate\Http\Request;
use App\Filters\V2\CustomerFilters;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CustomerFilters();
        $queryItems = $filter->transform($request);
        $includeInvoices = $request->query('includeInvoices');
        $customer = Customer::where($queryItems);
        if ($includeInvoices) {
            $customer->with('invoices');
        }
        return new CustomerCollection($customer->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $Customer = Customer::create($request->all());
        $data = ["message" => "Data Saved Successfully with id " . $Customer->id];
        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer->loadMissing('invoices'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
        return [
            'message Data Updated For ID ' . $customer->id
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
