<?php

declare(strict_types=1);

use App\Enums\RecurringTransferStatus;
use App\Models\RecurringTransfer;
use App\Models\RecurringTransferLog;
use App\Models\User;
use App\Models\Wallet;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('get recurring transfer logs', function () {
    $user = User::factory()
        ->has(Wallet::factory()->richChillGuy())
        ->create(['name' => 'John Doe', 'email' => 'test@test.com']);

    actingAs($user);

    $transfer = RecurringTransfer::factory()
        ->create([
            'source_id' => $user->wallet->id,
            'target_id' => $user->wallet->id,
        ]);

    RecurringTransferLog::factory()
        ->count(10)
        ->transferId($transfer->id)
        ->status(RecurringTransferStatus::VALID)
        ->create();

    getJson(sprintf('/api/v1/wallet/recurring-transfer/%d/logs', $transfer->id))
        ->assertOk()
        ->assertJsonCount(10, 'data');
});

test('recurring transfer not found', function () {
    $user = User::factory()
        ->has(Wallet::factory()->richChillGuy())
        ->create(['name' => 'John Doe', 'email' => 'test@test.com']);

    actingAs($user);

    getJson('/api/v1/wallet/recurring-transfer/5/logs')
        ->assertNotFound();
});

test('must be authenticated to get recurring transfer', function () {
    getJson('/api/v1/wallet/recurring-transfer/5/logs')
        ->assertUnauthorized();
});
