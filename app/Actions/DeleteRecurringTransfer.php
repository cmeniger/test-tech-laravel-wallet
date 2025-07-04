<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\RecurringTransfer;
use Illuminate\Support\Facades\DB;

readonly class DeleteRecurringTransfer
{
    public function __invoke(RecurringTransfer $recurringTransfer): void
    {
        DB::transaction(function () use ($recurringTransfer) {
            $recurringTransfer->logs()->delete();
            $recurringTransfer->delete();
        });
    }
}
