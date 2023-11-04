<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{

    protected $allowsParms = [];

    protected $columnMap = [];

    protected $allowedMethods = [];

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
