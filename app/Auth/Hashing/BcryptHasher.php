<?php

namespace App\Auth\Hashing;

use RuntimeException;
use App\Auth\Hashing\Hasher;

class BcryptHasher implements Hasher
{   
    /**
     * Hashes a given string
     *
     * @param string $plain
     * @return string hashed password
     * @throws RuntimeException
     */
    public function create($plain) {
        $hash = password_hash($plain, PASSWORD_BCRYPT, $this->options());

        if (!$hash) {
            throw new RuntimeException('Bcrypt not supported');
        }

        return $hash;
    }

    /**
     * Checks if given password match hashed password
     *
     * @param string $plain
     * @param string $hash
     * @return boolean
     */
    public function check($plain, $hash) {
        return password_verify($plain, $hash);
    }
    
    /**
     * Checks if the password needs to be rehash
     *
     * @param string $hash
     * @return boolean
     */
    public function needsRehash($hash) {
        return password_needs_rehash($hash, PASSWORD_BCRYPT, $this->options());
    }

    /**
     * BCRYPT Options
     *
     * @return array
     */
    public function options()
    {
        return [
            'cost' => 12
        ];
    }
}
