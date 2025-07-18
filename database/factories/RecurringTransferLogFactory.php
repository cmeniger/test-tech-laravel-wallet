<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\RecurringTransferStatus;
use App\Models\RecurringTransferLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RecurringTransferLog>
 */
class RecurringTransferLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'transfer_id' => 0,
            'status' => RecurringTransferStatus::VALID,
            'comment' => '',
        ];
    }

    public function transferId(int $transferId): static
    {
        return $this->state(fn (array $attributes) => [
            'transfer_id' => $transferId,
        ]);
    }

    public function status(RecurringTransferStatus $status): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => $status,
        ]);
    }
}
