<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function update(
        User $user,
        array $input
    ): void {
        $validatedData = Validator::make(
            data: $input,
            rules: $this->rules($user)
        )->validateWithBag('updateProfileInformation');

        if (isset($validatedData['photo'])) {
            $user->updateProfilePhoto($validatedData['photo']);
        }

        if ($validatedData['email'] !== $user->email
            && $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $validatedData);
        } else {
            $user->forceFill([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
            ])->save();
        }
    }

    protected function updateVerifiedUser(
        User $user,
        array $data
    ): void {
        $user->forceFill([
            'name' => $data['name'],
            'email' => $data['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }

    protected function rules(User $user): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'photo' => [
                'nullable',
                'mimes:jpg,jpeg,png',
                'image',
                'max:1024',
            ],
        ];
    }
}
