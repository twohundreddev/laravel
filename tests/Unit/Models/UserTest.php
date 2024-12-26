<?php

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

it('extends Authenticatable', function (): void {
    expect(User::class)
        ->toExtend(Authenticatable::class);
});

it('implements MustVerifyEmail', function (): void {
    expect(User::class)
        ->toImplement(MustVerifyEmail::class);
});

it('has traits', function (): void {
    expect(User::class)
        ->toUseTraits([
            HasApiTokens::class,
            HasFactory::class,
            HasProfilePhoto::class,
            HasUlids::class,
            Notifiable::class,
            TwoFactorAuthenticatable::class,
        ]);
});

it('has fillable attributes', function (): void {
    expect(User::class)
        ->toHaveFillableAttributes([
            'name',
            'email',
            'password',
        ]);
});

it('has hidden attributes', function (): void {
    expect(User::class)
        ->toHaveHiddenAttributes([
            'password',
            'remember_token',
            'two_factor_recovery_codes',
            'two_factor_secret',
        ]);
});

it('has appends attributes', function (): void {
    expect(User::class)
        ->toHaveAppendsAttributes([
            'profile_photo_url',
        ]);
});

it('has casts attributes', function (): void {
    expect(User::class)
        ->toHaveCastsAttributes([
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ]);
});
