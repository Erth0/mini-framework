<?php

namespace App\Rules;

use App\Models\User;

class ExistsRule
{
    public function validate($field, $value, $params, $fields)
    {
        return User::where($field, $value)->first() === null;
    }
}