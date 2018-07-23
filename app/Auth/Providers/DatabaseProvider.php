<?php

namespace App\Auth\Providers;

use App\Models\User;
use App\Auth\Providers\UserProvider;

class DatabaseProvider implements UserProvider
{

    /**
     * Get an user from database by email
     *
     * @param string $username
     * @return $user
     */
    public function getByUsername($username)
    {
        return User::where('email', $username)->first();
    }


    /**
     * Get an user from database by id
     *
     * @param integer $id
     * @return $user
     */
    public function getById($id)
    {
        return User::find($id);
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
        return User::find($id)->update([
            'password' => $hash
        ]);

    }


    public function getUserByRememberIdentifier($identifier)
    {
        return User::where('remember_identifier', $identifier)->first();;
    }


    public function clearUserRememberToken($id) 
    {
        return User::find($id)->update([
            'remember_identifier' => null,
            'remember_token' => null
        ]);
    }

    public function setUserRememberToken($id, $identifier, $token) 
    {
        return User::find($id)->update([
            'remember_identifier' => $identifier,
            'remember_token' => $token
        ]);
    }
}
