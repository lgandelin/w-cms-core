<?php

namespace CMS\Repositories;

use CMS\Entities\User;

interface UserRepositoryInterface
{
    public function findByID($userID);

    public function findByLogin($userLogin);

    public function findAll();

    public function createUser(User $user);

    public function updateUser(User $user);

    public function deleteUser($userID);
}