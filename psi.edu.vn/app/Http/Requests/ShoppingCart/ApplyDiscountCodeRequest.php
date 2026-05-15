<?php

namespace App\Http\Requests\ShoppingCart;

use App\Admin\Http\Requests\BaseRequest;
use App\Models\Discount;

class ApplyDiscountCodeRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'code' => ['required'],
            'cart_id' => ['nullable'],
            'qty' => ['nullable'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $discount = Discount::where('code', $this->code)->first();
            if ($discount) {
                if ($discount->max_usage <= 0) {
                    $validator->errors()->add('code', __('Mã giảm giá đã hết lượt sử dụng'));
                }
            } else {
                $validator->errors()->add('code', __('Mã giảm giá không tồn tại'));
            }
        });
    }
}
