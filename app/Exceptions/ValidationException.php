<?php

namespace App\Exceptions;

use Exception;
use Psr\Http\Message\RequestInterface;


class ValidationException extends Exception
{
    public function __construct(RequestInterface $request, array $errors) 
    {
        $this->request = $request;
        $this->errors = $errors;
    }

    /**
     * Get the path  of the exception
     *
     * @return object path
     */
    public function getPath()
    {
        return $this->request->getUri()->getPath();
    }

    /**
     * Get the Old inputs from the requested body
     *
     * @return request
     */ 
    public function getOldInput()
    {
        return $this->request->getParsedBody();
    }

    /**
     * Returns errors
     *
     * @return errors
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
