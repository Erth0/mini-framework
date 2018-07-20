<?php

namespace App\Auth\Providers;

use App\Models\User;
use Doctrine\ORM\EntityManager;
use App\Auth\Providers\UserProvider;

class DatabaseProvider implements UserProvider
{
    protected $db;
    
    public function __construct(EntityManager $db) 
    {
        $this->db = $db;
    }

    /**
     * Get an user from database by email
     *
     * @param string $username
     * @return $user
     */
    public function getByUsername($username)
    {
        return $this->db->getRepository(User::class)->findOneBy([
            'email' => $username
        ]);
    }


    /**
     * Get an user from database by id
     *
     * @param integer $id
     * @return $user
     */
    public function getById($id)
    {
        return $this->db->getRepository(User::class)->find($id);
    }


    /**
     * Rehash the password and updates the database
     *
     * @param object $user
     * @param string $password
     * @return void
     */
    public function updateUserPasswordHash($id, $hash)
    {
        $this->db->getRepository(User::class)->find($id)->update([
            'password' => $hash
        ]);

        $this->db->flush();
    }


    public function getUserByRememberIdentifier($identifier)
    {
        return $this->db->getRepository(User::class)->findOneBy([
            'remember_identifier' => $identifier
        ]);
    }


    public function clearUserRememberToken($id) 
    {
        $this->db->getRepository(User::class)->find($id)->update([
            'remember_identifier' => null,
            'remember_token' => null
        ]);

        $this->db->flush();
    }

    public function setUserRememberToken($id, $identifier, $token) 
    {
        $this->db->getRepository(User::class)->find($id)->update([
            'remember_identifier' => $identifier,
            'remember_token' => $token
        ]);

        $this->db->flush();
    }
}
