<?php

namespace App\Config\Loaders;

use Exception;
use App\Config\Loaders\Loader;


class ArrayLoader implements Loader
{
    /**
     * Array Files
     *
     * @var string
     */ 
    protected $files;


    public function __construct(array $files) 
    {
        $this->files = $files;
    }

    /**
     * Parses the array from the given files
     *
     * @return array $parsed
     */
    public function parse()
    {
        $parsed = [];

        foreach ($this->files as $namespace => $path) {
            try {
                $parsed[$namespace] = require $path;
            } catch (Exception $e) {

            }
        }

        return $parsed;
    }
}