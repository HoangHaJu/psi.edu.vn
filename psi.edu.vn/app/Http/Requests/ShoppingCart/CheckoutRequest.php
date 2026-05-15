<?php

namespace App\Http\Requests\ShoppingCart;

use App\Admin\Http\Requests\BaseRequest;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Enums\Payment\PaymentMethod;
use App\Enums\Setting\SettingGroup;
use App\Models\ShoppingCart;
use Illuminate\Validation\Rules\Enum;

class CheckoutRequest extends BaseRequest
{
    protected $repository;
    public function __construct(
        SettingRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }
    protected function methodPost()
    {
        return [
            'qty' => ['required'],
            'isBuyNow' => ['nullable'],
            'code' => ['nullable', 'exists:App\Models\Discount,code'],
            'shopping_cart_id' => ['required'],
            'order.payment_method' => ['required', new Enum(PaymentMethod::class)],
            'order.email' => ['required'],
            'order.payment_image' => ['nullable'],
            'points' => ['nullable'],
            'order.province_id' => ['required', 'exists:App\Models\Province,id'],
            'order.district_id' => ['required', 'exists:App\Models\District,id'],
            'order.ward_id' => ['required', 'exists:App\Models\Ward,id'],
            'order.fullname' => ['required'],
            'order.address' => ['required'],
            'order.phone' => ['required'],
            'order.note' => ['nullable'],
            'order.name_other' => ['nullable'],
            'order.address_other' => ['nullable'],
            'order.phone_other' => ['nullable'],
            'order.note_other' => ['nullable'],
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $userId = auth()->id();
            if ($userId) {
                $cartIds = $this->input('shopping_cart_id');

                $invalidCartIds = ShoppingCart::whereIn('id', $cartIds)
                    ->where('user_id', '!=', $userId)
                    ->pluck('id')
                    ->all();

                if (!empty($invalidCartIds)) {
                    $validator->errors()->add('id', 'Một hoặc nhiều giỏ hàng không thuộc về người dùng hiện tại.');
                }
                if (isset($this->points)) {
                    $settingsGeneral = $this->repository->getByGroup([SettingGroup::General]);
                    $maxPointToUse = $settingsGeneral->where('setting_key', 'max_points_to_use')->first()->plain_value;
                    if ($this->points > $maxPointToUse) {
                        $validator->errors()->add('points', 'Số lượng điểm sử dụng vượt quá cho phép.');
                    }
                }
            }
        });
    }
}
