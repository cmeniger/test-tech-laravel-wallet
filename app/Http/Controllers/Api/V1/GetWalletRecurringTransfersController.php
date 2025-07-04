<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\RecurrentTransferResource;
use Illuminate\Http\Request;

class GetWalletRecurringTransfersController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return RecurrentTransferResource::collection(
            resource: $request->user()->wallet->recurringTransfers()->get()
        );
    }
}
