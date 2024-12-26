<?php

use Laravel\Jetstream\Jetstream;

use function Pest\Laravel\withoutVite;

test('registration screen can be rendered', function (): void {
    withoutVite();

    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function (): void {
    withoutVite();
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
