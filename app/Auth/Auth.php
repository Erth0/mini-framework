<?php

namespace App\Auth;

use Exception;
use App\Auth\Recaller;
use App\Auth\Hashing\Hasher;
use App\Session\SessionStore;
use Doctrine\ORM\EntityManager;
use App\Cookie\CookieJar;
use App\Auth\Providers\UserProvider;


class Auth 
{

    /**
     * Hasher  
     *
     * @var $hash
     */
    protected $hash;

    /**
     * User
     *
     * @var $user
     */
    protected $user;

    /**
     * Session
     *
     * @var $session
     */
    protected $session;


    /**
     * Recaller
     *
     * @var $recaller
     */
    protected $recaller;

    /**
     * CookieJar
     *
     * @var $cookie
     */
    protected $cookie;

    /**
     * UserProvider
     *
     * @var $provider
     */ 
    protected $provider;

    public function __construct(Hasher $hash, SessionStore $session, Recaller $recaller, CookieJar $cookie, UserProvider $provider) 
    {
        $this->hash = $hash;
        $this->session = $session;
        $this->recaller = $recaller;
        $this->cookie = $cookie;
        $this->provider = $provider;
    }

    /**
     * Logout clear user session
     *
     * @return void
     */
    public function logout()
    {
        $this->provider->clearUserRememberToken($this->user->id);
        $this->cookie->clear('remember');
        $this->session->clear($this->key());
    }

    /**
     * Attempts to authenticate a user
     * returns true if credentials are correct
     *
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function attempt($username, $password, $remember = false)
    {
        $user = $this->provider->getByUsername($username);

        if (!$user || !$this->hasValidCredentials($user, $password)) {
            return false;
        }

        if ($this->needsRehash($user)) {
            $this->provider->updateUserPasswordHash($user->id, $this->hash->create($password));
        }
        
        $this->setUserSession($user);

        if ($remember) {
            $this->setRememberToken($user);
        }

        return true;

    }

    public function setUserFromCookie()
    {
        list($identifier, $token) = $this->recaller->splitCookieValue($this->cookie->get('remember'));
        
        if (!$this->provider->getUserByRememberIdentifier($identifier)) {
            $this->cookie->clear('remember');
            return;
        }

        if(!$user = $this->recaller->validateToken($token, $user->remember_token)){
            
            $this->provider->clearUserRememberToken($this->user->id);

            $this->cookie->clear('remember');

            throw new Exception("Error Processing Request");
        }

        $this->setUserSession($user);
    }

    public function hasRecaller()
    {
        return $this->cookie->exists('remember');
    }

    protected function setRememberToken($user) 
    {
        list($identifier, $token) = $this->recaller->generate();

        $this->cookie->set('remember', $this->recaller->generateValueForCookie($identifier, $token));

        $this->provider->setUserRememberToken($user->id, $identifier, $this->recaller->getTokenHashForDatabase($token));
    }

    /**
     * Checks if the password needs rehash
     *
     * @param object $user
     * @return boolean
     */
    protected function needsRehash($user)
    {
        return $this->hash->needsRehash($user->password);
    }


    /**
     * Retunrs the current user
     *
     * @return user model
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * Checks if a user is loged in
     *
     * @return boolean
     */
    public function check()
    {
        return $this->hasUserInSession();
    }

    /**
     * Checks if the user exists in the session
     *
     * @return boolean
     */
    public function hasUserInSession()
    {
        return $this->session->exists($this->key());
    }

    /**
     * Sets the current user from session if exists
     *
     * @return user
     * @throws Exception
     */
    public function setUserFromSession()
    {
        $user = $this->provider->getById($this->session->get($this->key()));

        if (!$user) {
            throw new Exception('User not found');
        }

        $this->user = $user;
    }

    /**
     * Set user in the session
     *
     * @param object `$user`
     * @return void
     */
    protected function setUserSession($user) {
        $this->session->set($this->key(), $user->id);
    }

    /**
     * Returns the session key for the user
     *
     * @return void
     */
    protected function key() {
        return 'id';
    }

    /**
     * Checks if a user given credentials are valid
     *
     * @param object $user
     * @param string $password
     * @return boolean
     */
    protected function hasValidCredentials($user, $password) {
        return $this->hash->check($password, $user->password);
    }

}