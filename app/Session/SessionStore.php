<?php

namespace App\Session;

interface SessionStore 
{
    public function get($key, $default = null);

    public function set($key, $default = null);

    public function exists($key);
    
    public function clear(...$key);
}