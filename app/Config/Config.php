<?php

namespace App\Config;

use App\Config\Loaders\Loader;

class Config 
{
    /**
     * Config array
     *
     * @var array
     */
    protected $config = [];

    /**
     * Cache array
     *
     * @var array
     */
    protected $cache = [];

    /**
     * Load the arrays
     *
     * @param array $loaders
     * @return $this
     */
    public function load(array $loaders)
    {
        foreach ($loaders as $loader) {
            if (!$loader instanceof Loader) {
                continue;
            }

            $this->config = array_merge($this->config, $loader->parse());
        }

        return $this;
    }

    /**
     * Gets a value from the array
     *
     * @param string|integer $key
     * @param string $default
     * @return srting value
     */
    public function get($key, $default = null)
    {
        if($this->existsInCache($key)) {
            return $this->fromCache($key) ?? $default;
        }
        
        return $this->addToCache($key, $this->extractFromConfig($key));
    }

    /**
     * Gets an value from config by the given key
     *
     * @param string|integer $key
     * @return string
     */
    protected function extractFromConfig($key) {
        $filtered = $this->config;

        foreach(explode('.', $key) as $segment) {
            if ($this->exists($filtered, $segment)) {
                $filtered = $filtered[$segment];
                continue;
            }
            
            return;
        }

        return $filtered;
    }

    /**
     * Checks if the key exists in the cache
     *
     * @param string|integer $key
     * @return boolean
     */
    protected function existsInCache($key) {
        return isset($this->cache[$key]);
    }

    /**
     * Returns the value of the given key from cache
     *
     * @param string|integer $key
     * @return void
     */
    protected function fromCache($key) {
        return $this->cache[$key];
    }

    /**
     * Add a new value to cache
     *
     * @param string|integer $key
     * @param string|integer $value
     * @return void
     */
    protected function addToCache($key, $value) {
        $this->cache[$key] = $value;

        return $value;
    }

    /**
     * Check if the key exists in the config array
     *
     * @param array $config
     * @param string|integer $key
     * @return boolean
     */
    protected function exists(array $config, $key) {
        return array_key_exists($key, $config);
    }
}