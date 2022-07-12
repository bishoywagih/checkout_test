<?php

namespace App\Contracts;

interface Hash
{
    public function create($plain): string;
    public function check($plain, $hashed): bool;
}
