<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiException;
use App\Http\Resources\RecurrentTransferLogResource;
use Illuminate\Http\Request;

class GetWalletRecurringTransferLogsController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $recurringTransferId)
    {
        // Check if the user is authenticated and has access to the recurring transfer
        if (! $recurringTransfer = $request->user()->wallet->recurringTransfers()->find($recurringTransferId)) {
            throw new ApiException(
                message: 'Recurring transfer not found',
                code: 'NOT_FOUND',
                status: 404,
            );
        }

        return RecurrentTransferLogResource::collection(
            resource: $recurringTransfer->logs()->orderByDesc('created_at')->get()
        );
    }
}
