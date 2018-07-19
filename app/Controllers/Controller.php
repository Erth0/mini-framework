<?php

namespace App\Controllers;

use Valitron\Validator;
use App\Exceptions\ValidationException;

abstract class Controller 
{
    /**
     * Validates the request with the given rules
     *
     * @param object $request
     * @param array $rules
     * @return object $request parsed body
     */
    public function validate($request, array $rules)
    {
        $validator = new Validator($request->getParsedBody());

        $validator->mapFieldsRules($rules);

        if(!$validator->validate()) {
            throw new ValidationException($request, $validator->errors());
        }

        return $request->getParsedBody();
    }
}