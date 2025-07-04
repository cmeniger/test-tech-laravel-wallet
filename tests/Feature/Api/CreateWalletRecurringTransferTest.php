<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Wallet;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

test('create recurring transfer', function () {
    $user = User::factory()
        ->has(Wallet::factory()->richChillGuy())
        ->create(['name' => 'John Doe', 'email' => 'test@test.com']);

    User::factory()
        ->has(Wallet::factory()->richChillGuy())
        ->create(['name' => 'John Doe', 'email' => 'target@test.com']);

    actingAs($user);

    $this->assertDatabaseCount('recurring_transfers', 0);

    $request = postJson('/api/v1/wallet/recurring-transfer', [
        'target_email' => 'target@test.com',
        'start_at' => now()->addDays(1)->toDateString(),
        'end_at' => now()->addDays(10)->toDateString(),
        'amount' => 1000,
        'frequency' => 7,
        'reason' => 'Test transfer',
    ]);

    $request->assertCreated();

    $this->assertDatabaseHas('recurring_transfers', [
        'id' => $request->json('data.id'),
    ]);
});

// test('validation rules are respected', function (array $data, string $error) {
//     $user = User::factory()
//         ->has(Wallet::factory()->richChillGuy())
//         ->create(['name' => 'John Doe', 'email' => 'test@test.com']);

//     User::factory()
//         ->has(Wallet::factory()->richChillGuy())
//         ->create(['name' => 'John Doe', 'email' => 'target@test.com']);

//     actingAs($user);

//     postJson('/api/v1/wallet/recurring-transfer', $data)
//         ->assertJsonFragment([
//             'message' => $error,
//         ]);

// })->with([
//     'missing target email' => [
//         'data' => [
//             'start_at' => now()->addDays(1)->toDateString(),
//             'end_at' => now()->addDays(30)->toDateString(),
//             'amount' => 1000,
//             'frequency' => 7,
//             'reason' => 'Test transfer',
//         ],
//         'error' => 'The target email field is required.',
//     ],
//     'is email owner' => [
//         'data' => [
//             'target_email' => 'test@test.com',
//             'start_at' => now()->addDays(1)->toDateString(),
//             'end_at' => now()->addDays(30)->toDateString(),
//             'amount' => 1000,
//             'frequency' => 7,
//             'reason' => 'Test transfer',
//         ],
//         'error' => 'The selected target email is invalid.',
//     ],
//     'missing start_at' => [
//         'data' => [
//             'target_email' => 'target@test.com',
//             'end_at' => now()->addDays(30)->toDateString(),
//             'amount' => 1000,
//             'frequency' => 7,
//             'reason' => 'Test transfer',
//         ],
//         'error' => 'The start at field is required.',
//     ],
//     'missing end_at' => [
//         'data' => [
//             'target_email' => 'target@test.com',
//             'start_at' => now()->addDays(1)->toDateString(),
//             'amount' => 1000,
//             'frequency' => 7,
//             'reason' => 'Test transfer',
//         ],
//         'error' => 'The start at field must be a date before end at. (and 1 more error)',
//     ],
//     'start_at greater than end_at' => [
//         'data' => [
//             'target_email' => 'target@test.com',
//             'start_at' => now()->addDays(10)->toDateString(),
//             'end_at' => now()->addDays(1)->toDateString(),
//             'amount' => 1000,
//             'frequency' => 7,
//             'reason' => 'Test transfer',
//         ],
//         'error' => 'The start at field must be a date before end at.',
//     ],
//     'missing amount' => [
//         'data' => [
//             'target_email' => 'target@test.com',
//             'start_at' => now()->addDays(1)->toDateString(),
//             'end_at' => now()->addDays(30)->toDateString(),
//             'frequency' => 7,
//             'reason' => 'Test transfer',
//         ],
//         'error' => 'The amount field is required.',
//     ],
//     'missing frequency' => [
//         'data' => [
//             'target_email' => 'target@test.com',
//             'start_at' => now()->addDays(1)->toDateString(),
//             'end_at' => now()->addDays(30)->toDateString(),
//             'amount' => 1000,
//             'reason' => 'Test transfer',
//         ],
//         'error' => 'The frequency field is required.',
//     ],
// ]);

// test('must be authenticated to create recurring transfer', function () {
//     postJson('/api/v1/wallet/recurring-transfer')
//         ->assertUnauthorized();
// });
