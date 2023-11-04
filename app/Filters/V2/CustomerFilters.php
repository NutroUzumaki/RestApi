<?php

namespace App\Filters\V2;

use App\Filters\ApiFilter;

class CustomerFilters extends ApiFilter
{

    protected $allowsParms = [
        'id' => ['eq', 'gt', 'lt'],
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'postalCode' => ['eq', 'gt', 'lt']
    ];

    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    protected $allowedMethods = [
        'eq' => '=',
        'gt' => '>',
        'lt' => '<'
    ];
}
