<?php

namespace App\Validators\Auth;

use App\Validators\BaseValidator;
use App\Models\User;

abstract class Base extends BaseValidator
{
    public function checkEmailOnExists(string $email, bool $eq = true, string $message = 'Email already exists'): bool
    {
        $result = (bool) User::findBy('email', $email);

        if ($result === $eq) {
            $this->setError('email', $message);
        }

        return $result;
    }
}