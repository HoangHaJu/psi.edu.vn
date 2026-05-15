<?php

namespace App\Http\Requests\ShoppingCart;

use App\Admin\Http\Requests\BaseRequest;

class ChangeQtyRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'id' => ['required'],
            'code' => ['nullable', 'exists:App\Models\Discount,code'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required'],
            'qty' => ['required', 'integer', 'min:1'],
            'code' => ['nullable', 'exists:App\Models\Discount,code'],
        ];
    }
}
