<?php

namespace App\Admin\Services\Review;

use Illuminate\Http\Request;

interface ReviewServiceInterface
{
    public function store(Request $request);
}
