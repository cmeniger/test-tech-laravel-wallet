<?php

declare(strict_types=1);

use App\Models\RecurringTransfer;
use App\Models\User;
use App\Models\Wallet;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('get recurring transfers', function () {
    $user = User::factory()
        ->has(Wallet::factory()->richChillGuy())
        ->create(['name' => 'John Doe', 'email' => 'test@test.com']);
    
    $otherUser = User::factory()
        ->has(Wallet::factory()->richChillGuy())
        ->create(['name' => 'John Doe', 'email' => 'other@test.com']);

    actingAs($user);

    RecurringTransfer::factory()
        ->count(10)
        ->create([
            'source_id' => $user->wallet->id,
            'target_id' => $user->wallet->id,
        ]);
    
    RecurringTransfer::factory()
        ->count(3)
        ->create([
            'source_id' => $otherUser->wallet->id,
            'target_id' => $otherUser->wallet->id,
        ]);

    $response = getJson('/api/v1/wallet/recurring-transfer');
    $response->assertOk();
    $response->assertJsonCount(10, 'data');
    $response->assertJsonFragment([
        'email' => $user->email,
    ]);
});

test('must be authenticated to get recurring transfer', function () {
    getJson('/api/v1/wallet/recurring-transfer')
        ->assertUnauthorized();
});
