<?php

declare(strict_types=1);

use App\Enums\RecurringTransferStatus;
use App\Models\RecurringTransfer;
use App\Models\RecurringTransferLog;
use App\Models\User;
use App\Models\Wallet;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\deleteJson;

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

    $this->assertDatabaseCount('recurring_transfer_logs', 10);
    $this->assertDatabaseHas('recurring_transfers', [
        'id' => $transfer->id,
    ]);

    deleteJson(sprintf('/api/v1/wallet/recurring-transfer/%d', $transfer->id))
        ->assertNoContent();

    $this->assertDatabaseCount('recurring_transfer_logs', 0);
    $this->assertDatabaseMissing('recurring_transfers', [
        'id' => $transfer->id,
    ]);
});

test('user is not owner of recurring transfer', function () {
    $user = User::factory()
        ->has(Wallet::factory()->richChillGuy())
        ->create(['name' => 'John Doe', 'email' => 'test@test.com']);

    $otherUser = User::factory()
        ->has(Wallet::factory()->richChillGuy())
        ->create(['name' => 'John Doe', 'email' => 'other@test.com']);

    actingAs($user);

    $transfer = RecurringTransfer::factory()
        ->create([
            'source_id' => $otherUser->wallet->id,
            'target_id' => $otherUser->wallet->id,
        ]);

    deleteJson(sprintf('/api/v1/wallet/recurring-transfer/%d', $transfer->id))
        ->assertForbidden();
});

test('recurring transfer not found', function () {
    $user = User::factory()
        ->has(Wallet::factory()->richChillGuy())
        ->create(['name' => 'John Doe', 'email' => 'test@test.com']);

    actingAs($user);

    deleteJson('/api/v1/wallet/recurring-transfer/5')
        ->assertForbidden();
});

test('must be authenticated to get recurring transfer', function () {
    deleteJson('/api/v1/wallet/recurring-transfer/5')
        ->assertUnauthorized();
});
