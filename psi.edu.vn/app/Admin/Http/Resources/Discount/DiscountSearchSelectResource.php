<?php

namespace App\Admin\Http\Resources\Discount;

use App\Enums\Discount\DiscountType;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountSearchSelectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->type == DiscountType::Money){
            $type = $this->discount_value.'đ';
        }
        else{
            $type = $this->discount_value.'%';
        }
        return [
            'id' => $this->id,
            'text' => $this->code.' - Tối thiểu: '.$this->min_order_amount.'đ - Còn lại: '.$this->max_usage.' - Giảm: '.$type
        ];
    }
}
