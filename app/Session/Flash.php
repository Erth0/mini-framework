<?php

namespace App\Session;

use App\Session\SessionStore;

class Flash 
{
    /**
     * SessionStore
     *
     * @var $session
     */
    protected $session;

    /**
     * Session messages
     *
     * @var $messages
     */
    protected $messages;

    public function __construct(SessionStore $session)
    {
        $this->session = $session;

        $this->loadFlashMessagesIntoCache();

        $this->clear();
    }

    /**
     * Get the message from based on the key
     *
     * @param string|integer $key
     * @return void
     */
    public function get($key)
    {   
        if ($this->has($key)) {
            return $this->messages[$key];
        }
    }

    /**
     * Checks if the key exists in the session
     *
     * @param string|integer $key
     * @return boolean
     */
    public function has($key)
    {
        return isset($this->messages[$key]);
    }

    /**
     * Set in the flash given key and value
     *
     * @param string|integer $key
     * @param any $value
     * @return void
     */
    public function now($key, $value)
    {
        $this->session->set('flash', array_merge(
            $this->session->get('flash') ?? [], [$key => $value]
        ));
    }

    /**
     * Clean everything from the session with flash key
     *
     * @return void
     */
    protected function clear() {
        $this->session->clear('flash');
    }

    /**
     * Loads flash messages into the cach
     *
     * @return void
     */
    protected function loadFlashMessagesIntoCache() {
        $this->messages = $this->getAll();
    }

    /**
     * Get everything from session with the flash key
     *
     * @return void
     */
    protected function getAll()
    {
        return $this->session->get('flash');
    }
}