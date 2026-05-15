<?php

namespace App\Http\Requests\ShoppingCart;

use App\Admin\Http\Requests\BaseRequest;

class ShoppingCartRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'product_id' => ['required', 'exists:App\Models\Product,id'],
            'product_variation_id' => ['nullable', 'exists:App\Models\ProductVariation,id'],
            'qty' => ['required', 'integer', 'min:1'],
        ];
    }
}
