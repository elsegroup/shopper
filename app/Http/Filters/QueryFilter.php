<?php

namespace App\Http\Filters;

use Illuminate\Http\Request;

class QueryFilter
{
    protected $builder;
    protected $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }
        return $this->builder;
    }

    public function filters()
    {
        // if (!$this->request->has('filter')) return [];

        return $this->request->all();
    }
}
