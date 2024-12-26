<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    public function update(
        User $user,
        array $input
    ): void {
        $validatedData = Validator::make(
            data: $input,
            rules: $this->rules(),
            messages: $this->messages()
        )->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($validatedData['password']),
        ])->save();
    }

    protected function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
                'current_password:web',
            ],
            'password' => $this->passwordRules(),
        ];
    }

    protected function messages(): array
    {
        return [
            'current_password.current_password' => __('The provided password does not match your current password.'),
        ];
    }
}
