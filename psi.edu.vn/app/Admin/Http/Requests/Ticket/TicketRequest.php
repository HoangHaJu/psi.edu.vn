<?php

namespace App\Admin\Http\Requests\Ticket;

use App\Admin\Http\Requests\BaseRequest;

class TicketRequest extends BaseRequest
{
    protected function methodPost(): array
    {
        return [
            'name' => ['required', 'string'],
            'quantity' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'during' => ['required', 'numeric'],
            'description' => ['required'],
            'type' => ['required', 'in:normal,special'],
            'avatar' => ['nullable', 'string'],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Ticket,id'],
            'name' => ['nullable', 'string'],
            'quantity' => ['nullable', 'numeric'],
            'price' => ['nullable', 'numeric'],
            'during' => ['nullable', 'numeric'],
            'description' => ['required'],
            'type' => ['nullable', 'in:normal,special'],
            'avatar' => ['nullable', 'string'],
        ];
    }
}
