<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;

class CustomerFilters
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

    public function transform(Request $request)
    {
        $eloQuery = [];
        // dd($request->toArray());
        foreach ($this->allowsParms as $key => $operators) {
            // column operator value
            $query = $request->query($key);
            // dd($key, $query);
            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$key] ?? $key;

            if (is_array($query)) {
                foreach ($operators as $ops) {
                    if (isset($query[$ops])) {
                        $eloQuery[] = [$column, $this->allowedMethods[$ops], $query[$ops]];
                    }
                }
            } else {
                $eloQuery[] = [$column, '=', $query];
            }
        }
        return $eloQuery;
    }
}
