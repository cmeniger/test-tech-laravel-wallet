<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\CreateRecurringTransferForUser;
use App\Data\CreateRecurringTransferData;
use App\Http\Requests\Api\V1\CreateRecurringTransferRequest;
use App\Http\Resources\RecurrentTransferResource;
use DateTimeImmutable;

class CreateWalletRecurringTransfersController
{
    public function __invoke(CreateRecurringTransferRequest $request, CreateRecurringTransferForUser $createRecurringTransfer)
    {
        $transfer = $createRecurringTransfer(new CreateRecurringTransferData(
            source: $request->user()->wallet,
            target: $request->getTarget()->wallet()->firstOrFail(),
            amount: $request->input('amount'),
            frequency: $request->input('frequency'),
            startAt: new DateTimeImmutable($request->input('start_at')),
            endAt: new DateTimeImmutable($request->input('end_at')),
            reason: $request->input('reason', null),
        ));

        if ($request->input('execute_now', false)) {
            // Execute the transfer immediately
        }

        return new RecurrentTransferResource($transfer);
    }
}
