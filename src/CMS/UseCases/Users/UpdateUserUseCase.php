<?php

namespace CMS\UseCases\Users;

use CMS\Structures\UserStructure;

interface UpdateUserUseCase extends GetUserUseCase
{
    public function run($userID, UserStructure $userStructure);
    public function anotherUserExistsWithSameLogin($userID, $userLogin);
}