<?php

namespace App\Session;

interface SessionStore 
{
    /**
     * Get the given key
     *
     * @param integer|string $key
     * @param any $default
     * @return void
     */
    public function get($key, $default = null);

    /**
     * Sets the given key
     *
     * @param integer|string $key
     * @param any $default
     * @return void
     */
    public function set($key, $default = null);

    /**
     * Check if key exists
     *
     * @param integer|string $key
     * @return boolean
     */
    public function exists($key);
    
    /**
     * Cleans every given key
     *
     * @param array|string|integer ...$key
     * @return void
     */
    public function clear(...$key);
}