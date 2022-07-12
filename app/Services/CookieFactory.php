<?php

namespace App\Services;

class CookieFactory
{
    protected string $seperator = '|';

    /**
     * @throws \Exception
     */
    public function generate(): array
    {
        return [$this->generateIdentifier(), $this->generateToken()];
    }

    public function generateValueForCookie($identifier, $token): string
    {
        return $identifier . $this->seperator . $token;
    }

    /**
     * @throws \Exception
     */
    protected function generateIdentifier(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * @throws \Exception
     */
    protected function generateToken(): string
    {
        return bin2hex(random_bytes(64));
    }

    public function getTokenHashForDatabase($token): string
    {
        return hash('sha256', $token);
    }

    public function splitCookieValue($value): array
    {
        return explode($this->seperator, $value);
    }

    public function validateToken($plain, $hashed): bool
    {
        return $this->getTokenHashForDatabase($plain) === $hashed;
    }
}
