<?php

namespace App\Auth;

class Recaller
{
    protected $seperator = '|';

    public function generate()
    {
        return [$this->generateIdentifier(), $this->generateToken()];
    }

    public function generateValueForCookie($identifier, $token)
    {
        return $identifier . $this->seperator . $token;
    }

    public function splitCookieValue($value)
    {
        return explode($this->seperator, $value);
    }

    public function getTokenHashForDatabase($token)
    {
        return hash('sha256', $token);
    }

    public function validateToken($plain, $hashed)
    {
        return $this->getTokenHashForDatabase($plain) === $hashed;
    }

    protected function generateIdentifier()
    {
        return bin2hex(random_bytes(32));
    }

    protected function generateToken()
    {
        return bin2hex(random_bytes(32));
    }
    
}