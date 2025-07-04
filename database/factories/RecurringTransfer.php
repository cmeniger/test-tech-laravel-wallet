<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Wallet>
 */
class Recurringtransfer extends Factory
{
    public function definition(): array
    {
        return [
            'source_id' => Wallet::factory(),
            'target_id' => Wallet::factory(),
            'amount' => 0,
            'frequency' => 0,
            'reason' => '',
        ];
    }

    public function amount(int $amount): static
    {
        return $this->state(fn (array $attributes) => [
            'amount' => $amount,
        ]);
    }

    public function frequency(int $frequency): static
    {
        return $this->state(fn (array $attributes) => [
            'frequency' => $frequency,
        ]);
    }
}
