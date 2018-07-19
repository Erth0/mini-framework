<?php

namespace App\Models;

abstract class Model {

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }
    }

    public function __isset($name)
    {
        if (property_exists($this, $name)) {
            return true;
        }

        return false;
    }
    
    /**
     * Update database based on give columns and data
     *
     * @param array $columns
     * @return void
     */
    public function update(array $columns)
    {
        foreach ($columns as $column => $value) {
            $this->{$column} = $value;
        }
    }
}