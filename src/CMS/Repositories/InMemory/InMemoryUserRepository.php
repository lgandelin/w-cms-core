<?php

namespace CMS\Repositories\InMemory;

use CMS\Converters\UserConverter;
use CMS\Repositories\UserRepositoryInterface;
use CMS\Structures\UserStructure;

class InMemoryUserRepository implements UserRepositoryInterface {

    private $users;

    public function __construct()
    {
        $this->users = [];
    }

    public function findByID($userID)
    {
        foreach ($this->users as $user) {
            if ($user->ID == $userID)
                return $user;
        }

        return false;
    }

    public function findByLogin($login)
    {
        foreach ($this->users as $user) {
            if ($user->login == $login)
                return $user;
        }

        return false;
    }

    public function findAll()
    {
        return $this->users;
    }

    public function createUser(UserStructure $userStructure)
    {
        $this->users[]= $userStructure;
    }

    public function updateUser($userID, UserStructure $userStructure)
    {
        foreach ($this->users as $user) {
            if ($user->ID == $userID) {
                if ($userStructure->password) $user->password = $userStructure->password;
                $user->last_name = $userStructure->last_name;
                $user->first_name = $userStructure->first_name;
                $user->email= $userStructure->email;
            }
        }
    }

    public function deleteUser($userID)
    {
        foreach ($this->users as $i => $user) {
            if ($user->ID == $userID) {
                unset($this->users[$i]);
            }
        }
    }
}