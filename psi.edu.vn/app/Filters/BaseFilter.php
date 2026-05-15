<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class BaseFilter
{
    protected $request;
    protected $query;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($query)
    {
        $this->query = $query;

        foreach ($this->filters() as $method) {
            if (method_exists($this, $method)) {
                $this->{$method}();
            }
        }

        return $this->query;
    }
    abstract protected function filters(): array;
}
