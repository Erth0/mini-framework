<?php

namespace App\Security;

use App\Session\SessionStore;


class Csrf 
{   
    /**
     * Determines whether the token should persist or not
     *
     * @var boolean
     */
    protected $persistToken = false;

    /**
     * SessionStore
     *
     * @var $session
     */
    protected $session;

    public function __construct(SessionStore $session) 
    {
        $this->session = $session;
    }

    /**
     * Returns the session key for the csrf token
     *
     * @return string
     */ 
    public function key()
    {
        return '_token';
    }
    
    /**
     * Generates a unique 32 byte token
     *
     * @return string $token
     */
    public function token()
    {
        if ($this->tokenNeedsToBeGenerated()) {
            return $this->getTokenFromSession();
        }

        $this->session->set($this->key(), $token = bin2hex(random_bytes(32)));

        return $token;
    }

    /**
     * Checks whether the give token match our session token
     *
     * @param string $token
     * @return boolean
     */
    public function tokenIsValid($token)
    {
        return $token === $this->session->get($this->key());
    }

    /**
     * Get the token from session based on the defined key above
     *
     * @return void
     */
    protected function getTokenFromSession()
    {
        return $this->session->get($this->key());
    }

    /**
     * Checks whether the token needs to be generated or not
     *
     * @return void
     */
    protected function tokenNeedsToBeGenerated()
    {
        if ($this->session->exists($this->key())) {
            return true;
        }

        if ($this->shouldPersistToken()) {
            return false;
        }

        return $this->session->exists($this->key());
    }

    /**
     * Check if token should persist 
     *
     * @return boolean
     */
    protected function shouldPersistToken()
    {
        return $this->persistToken;
    }

}