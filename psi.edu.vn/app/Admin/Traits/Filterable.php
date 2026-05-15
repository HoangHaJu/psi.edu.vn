<?php

namespace App\Admin\Traits;

use Illuminate\Http\Request;

trait Filterable
{
    public function scopeFilter($query, $filterClass, Request $request)
    {
        if (class_exists($filterClass)) {
            $filter = new $filterClass($request);
            return $filter->apply($query);
        }

        return $query;
    }
}
