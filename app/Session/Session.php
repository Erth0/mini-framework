<?php

namespace App\Session;

use App\Session\SessionStore;

class Session implements SessionStore
{
    /**
     * Get the given key from session or if default is set
     * returns the setted key
     *
     * @param integer|string $key
     * @param any $default
     * @return void
     */
    public function get($key, $default = null) {
        if ($this->exists($key)) {
            return $_SESSION[$key];
        }

        return $default;
    }

    /**
     * Set into the session the given key and the given value if setted
     *
     * @param integer|string $key
     * @param any $value
     * @return void
     */
    public function set($key, $value = null) {
        if (is_array($key)) {
            foreach ($key as $sessionKey => $sessionValue) {
                $_SESSION[$sessionKey] = $sessionValue;

                return;
            }
        }

        $_SESSION[$key] = $value;
    }

    /**
     * Checks whether the given key exists in the session
     *
     * @param integer|string $key
     * @return void
     */
    public function exists($key) {
        return isset($_SESSION[$key]) && !empty($_SESSION[$key]);
    }
    
    /**
     * Clean the given keys from the session
     *
     * @param integer|string ...$key
     * @return void
     */
    public function clear(...$key) {
        foreach ($key as $sessionKey) {
            unset($_SESSION[$sessionKey]);
        }
    }
}
