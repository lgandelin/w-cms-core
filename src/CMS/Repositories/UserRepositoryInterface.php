<?php

namespace CMS\Repositories;

use CMS\Entities\User;

interface UserRepositoryInterface {

    public function findByLogin($login);
    public function findAll();
    public function createUser(User $user);
    public function updateUser(User $user);
    public function deleteUser(User $user);
    
}