<?php

namespace CMSTests\Repositories;

use CMS\Entities\User;
use CMS\Repositories\UserRepositoryInterface;
use CMS\Structures\UserStructure;

class InMemoryUserRepository implements UserRepositoryInterface
{
    private $users;

    public function __construct()
    {
        $this->users = [];
    }

    public function findByID($userID)
    {
        foreach ($this->users as $user) {
            if ($user->getID() == $userID) {
                return $user;
            }
        }

        return false;
    }

    public function findByLogin($userLogin)
    {
        foreach ($this->users as $user) {
            if ($user->getLogin() == $userLogin) {
                return $user;
            }
        }

        return false;
    }

    public function findAll()
    {
        return $this->users;
    }

    public function createUser(User $user)
    {
        $this->users[]= $user;
    }

    public function updateUser(user $user)
    {
        foreach ($this->users as $userModel) {
            if ($userModel->getID() == $user->getID()) {
                if ($user->getLogin()) {
                    $userModel->setLogin($user->getLogin());
                }
                if ($user->getPassword()) {
                    $userModel->setPAssword($user->getPassword());
                }
                $userModel->setLastName($user->getLastName());
                $userModel->setFirstName($user->getFirstName());
                $userModel->setEmail($user->getEmail());
            }
        }
    }

    public function deleteUser($userID)
    {
        foreach ($this->users as $i => $user) {
            if ($user->getID() == $userID) {
                unset($this->users[$i]);
            }
        }
    }
}