<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\DeleteRecurringTransfer;
use App\Exceptions\ApiException;
use Illuminate\Http\Request;

class DeleteWalletRecurringTransfersController
{
    public function __invoke(Request $request, int $recurringTransferId, DeleteRecurringTransfer $deleteRecurringTransfer)
    {
        // Check if the user is authenticated and has access to the recurring transfer
        if (! $recurringTransfer = $request->user()->wallet->recurringTransfers()->find($recurringTransferId)) {
            throw new ApiException(
                message: 'Recurring transfer not found',
                code: 'NOT_AUTHORIZED',
                status: 403,
            );
        }

        $deleteRecurringTransfer($recurringTransfer);

        return response()->noContent(204);
    }
}
