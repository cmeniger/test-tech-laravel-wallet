<?php

declare(strict_types=1);

namespace App\Actions;

use App\Mail\LowBalanceMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

readonly class SendEmailWhenLowBalance
{
    public function __invoke(User $user): void
    {
        Mail::to(users: $user->email)->send(mailable: new LowBalanceMail);
    }
}
