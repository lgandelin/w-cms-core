<?php

namespace CMS\UseCases\Users;

interface DeleteUserUseCase extends GetUserUseCase
{
    public function run($userID);
}