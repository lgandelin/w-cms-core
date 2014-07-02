<?php

namespace CMS\UseCases\Users;

use CMS\Structures\UserStructure;

interface CreateUserUseCase
{
    public function run(UserStructure $userStructure);
    public function anotherUserExistsWithSameLogin($userLogin);
}