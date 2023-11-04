<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Invoice;
use App\Http\Requests\V1\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\InvoiceCollection;
use App\Http\Resources\v1\InvoiceResource;
use App\Filters\V2\InvoiceFilters;
use Illuminate\Http\Request;
use App\Http\Requests\V1\BulkStoreInvoicesRequest;
use Illuminate\Support\Arr;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new InvoiceFilters();
        $queryParms = $filter->transform($request);
        $includeCustomers = $request->query('includeCustomers');
        $invoice = Invoice::where($queryParms);
        if ($includeCustomers) {
            $invoice = $invoice->with('customer');
        }
        return new InvoiceCollection($invoice->paginate()->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        //
    }

    public function BluckStore(BulkStoreInvoicesRequest $request)
    {
        $bluck = collect($request->all())->map(function ($arr, $key): array {
            return Arr::except($arr, ['customerId', 'billedDate', 'paidDated']);
        });
        Invoice::insert($bluck->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return $invoice->load('customer');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
