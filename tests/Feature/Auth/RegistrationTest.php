<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('registration screen can be rendered', function () {
    $response = get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $user = User::where(column: 'email', operator: '=', value: 'test@example.com')->first();
    $this->assertTrue($user?->wallet()?->exists());

    assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
