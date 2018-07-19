<?php

namespace App\Auth\Hashing;

interface Hasher
{   
    /**
     * Create Hash
     *
     * @param string $plain
     * @return string
     */
    public function create($plain);

    /**
     * Checks if given password match the hash
     *
     * @param string $plain
     * @param string $hash
     * @return boolean
     */
    public function check($plain, $hash);
    
    /**
     * Checks if password needs rehash
     *
     * @param string $hash
     * @return boolean
     */
    public function needsRehash($hash);
    
}