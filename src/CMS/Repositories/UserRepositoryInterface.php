<?php

namespace CMS\Repositories;

use CMS\Structures\UserStructure;

interface UserRepositoryInterface {

    public function findByID($userID);
    public function findByLogin($userLogin);
    public function findAll();
    public function createUser(UserStructure $userStructure);
    public function updateUser($userID, UserStructure $userStructure);
    public function deleteUser($userID);
    
}