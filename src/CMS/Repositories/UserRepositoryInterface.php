<?php

namespace CMS\Repositories;

interface UserRepositoryInterface {

    public function findByLogin($login);
    public function findAll();
    public function createUser(\CMS\Entities\User $user);
    public function updateUser(\CMS\Entities\User $user);
    public function deleteUser(\CMS\Entities\User $user);
}