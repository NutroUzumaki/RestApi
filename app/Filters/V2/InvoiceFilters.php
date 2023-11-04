<?php

namespace App\Filters\V2;

use App\Filters\ApiFilter;

class InvoiceFilters extends ApiFilter
{

    protected $allowsParms = [
        'id' => ['eq', 'gt', 'lt', 'ne', 'gte', 'lte'],
        'customerId' => ['eq', 'gt', 'lt', 'ne', 'gte', 'lte'],
        'amount' => ['eq', 'gt', 'lt', 'ne', 'gte', 'lte'],
        'status' =>  ['eq', 'ne'],
        'billedDate' => ['eq', 'gt', 'lt', 'ne', 'gte', 'lte'],
        'paidDated' => ['eq', 'gt', 'lt', 'ne', 'gte', 'lte']
    ];

    protected $columnMap = [
        'customerId' => 'customer_id',
        'billedDate' => 'billed_date',
        'paidDated' => 'paid_date'
    ];

    protected $allowedMethods = [
        'eq' => '=',
        'gt' => '>',
        'lt' => '<',
        'ne' => '!=',
        'gte' => '>=',
        'lte' => '<='
    ];
}
