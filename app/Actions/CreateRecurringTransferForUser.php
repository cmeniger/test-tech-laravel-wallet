<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\CreateRecurringTransferData;
use App\Models\RecurringTransfer;

readonly class CreateRecurringTransferForUser
{
    public function __invoke(CreateRecurringTransferData $data): RecurringTransfer
    {
        return RecurringTransfer::create([
            'source_id' => $data->source->id,
            'target_id' => $data->target->id,
            'start_at' => $data->startAt,
            'end_at' => $data->endAt,
            'amount' => $data->amount,
            'frequency' => $data->frequency,
            'reason' => $data->reason,
        ]);
    }
}
