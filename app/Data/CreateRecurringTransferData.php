<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\Wallet;
use DateTimeImmutable;

final readonly class CreateRecurringTransferData
{
    public function __construct(
        public Wallet $source,
        public Wallet $target,
        public DateTimeImmutable $startAt,
        public DateTimeImmutable $endAt,
        public int $amount,
        public int $frequency,
        public ?string $reason = null,
    ) {}
}
