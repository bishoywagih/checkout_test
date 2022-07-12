<?php

namespace App\Services;

use App\Contracts\Hash;

class BCryptHash implements Hash
{
    public function create($plain): string
    {
        return password_hash($plain, PASSWORD_BCRYPT, $this->options());
    }

    public function check($plain, $hashed): bool
    {
        return password_verify($plain, $hashed);
    }

    protected function options()
    {
        return [
            'cost' => 12
        ];
    }
}
