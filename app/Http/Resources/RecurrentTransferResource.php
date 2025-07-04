<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class RecurrentTransferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->target()->first()->user()->first()->email,
            'amount' => $this->amount,
            'frequency' => $this->frequency,
            'reason' => $this->reason,
        ];
    }
}
