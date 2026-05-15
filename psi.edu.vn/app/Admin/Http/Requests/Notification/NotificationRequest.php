<?php

namespace App\Admin\Http\Requests\Notification;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Notification\NotificationStatus;
use App\Enums\Notification\NotificationType;
use Illuminate\Validation\Rules\Enum;

class NotificationRequest extends BaseRequest
{
    protected function methodPost(): array
    {
        return [
            'title' => ['required', 'string'],
            'message' => ['required'],
            'option' => ['required'],
            'type' => ['required', new Enum(NotificationType::class)],
            'admin_id' => ['nullable'],
            'status' => ['required', new Enum(NotificationStatus::class)],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Notification,id'],
            'title' => ['required', 'string'],
            'message' => ['required'],
            'status' => ['required', new Enum(NotificationStatus::class)],
        ];
    }
}
