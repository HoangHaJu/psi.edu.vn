<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class AccountActivation extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function build()
    {
        $activationUrl = URL::temporarySignedRoute(
            'admin.activation.index',
            now()->addMinutes(30),
            [
                'token' => $this->admin->token_active_account,
                'id' => $this->admin->id,
            ]
        );

        return $this->subject('Kích hoạt tài khoản')
            ->view('mails.account-activation')
            ->with([
                'url' => $activationUrl,
                'admin' => $this->admin
            ]);
    }
}
