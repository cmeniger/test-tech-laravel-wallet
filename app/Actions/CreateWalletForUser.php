<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;

readonly class CreateWalletForUser
{
    public function __invoke(User $user): User
    {
        if ($user->wallet()->exists()) {
            return $user->refresh();
        }

        return DB::transaction(callback: function () use ($user): User {
            $user->wallet()->create()->refresh();

            return $user->refresh();
        });
    }
}
