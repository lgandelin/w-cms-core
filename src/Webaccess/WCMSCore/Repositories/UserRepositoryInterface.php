<?php

namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\User;

interface UserRepositoryInterface
{
    public function findByID($userID);

    public function findByLogin($userLogin);

    public function findAll();

    public function createUser(User $user);

    public function updateUser(User $user);

    public function deleteUser($userID);
}
