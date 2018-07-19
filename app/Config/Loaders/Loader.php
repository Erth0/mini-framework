<?php 

namespace App\Config\Loaders;

interface Loader
{
    /**
     * Parses an array
     *
     * @return array
     */
    public function parse();
}