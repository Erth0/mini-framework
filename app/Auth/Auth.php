<?php

namespace App\Auth;

use Exception;
use App\Models\User;
use App\Auth\Hashing\Hasher;
use App\Session\SessionStore;
use Doctrine\ORM\EntityManager;


class Auth 
{
    /**
     * Database EntityManager
     *
     * @var $db
     */
    protected $db;

    /**
     * Hasher  
     *
     * @var $hash
     */
    protected $hash;

    /**
     * Session
     *
     * @var $session
     */
    protected $session;

    /**
     * User
     *
     * @var $user
     */
    protected $user;

    public function __construct(EntityManager $db, Hasher $hash, SessionStore $session) 
    {
        $this->db = $db;
        $this->hash = $hash;
        $this->session = $session;
    }

    /**
     * Attempts to authenticate a user
     * returns true if credentials are correct
     *
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function attempt($username, $password)
    {
        $user = $this->getByUsername($username);

        if (!$user || !$this->hasValidCredentials($user, $password)) {
            return false;
        }

        if ($this->needsRehash($user)) {
            $this->rehashPassword($user, $password);
        }
        
        $this->setUserSession($user);

        return true;

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
     * Rehash the password and updates the database
     *
     * @param object $user
     * @param string $password
     * @return void
     */
    protected function rehashPassword($user, $password)
    {
        $this->db->getRepository(User::class)->find($user->id)->update([
            'password' => $this->hash->create($password)
        ]);

        $this->db->flush();
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
        $user = $this->getById($this->session->get($this->key()));

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

    /**
     * Get an user from database by id
     *
     * @param integer $id
     * @return $user
     */
    protected function getById($id)
    {
        return $this->db->getRepository(User::class)->find($id);
    }

    /**
     * Get an user from database by email
     *
     * @param string $username
     * @return $user
     */
    protected function getByUsername($username)
    {
        return $this->db->getRepository(User::class)->findOneBy([
            'email' => $username
        ]);
    }
}