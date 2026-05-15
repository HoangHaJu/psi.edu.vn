<?php

namespace App\Admin\Services\Transaction;

use Illuminate\Http\Request;

interface TransactionServiceInterface
{
    public function uploadPaymentImage(Request $request);
    public function store(Request $request);
    public function update(Request $request);
    public function delete($id);
    public function confirm($id);
    public function cancel($id);
}
