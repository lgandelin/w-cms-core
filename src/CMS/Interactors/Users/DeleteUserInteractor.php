<?php

namespace CMS\Interactors\Users;

use CMS\UseCases\Users\DeleteUserUseCase;

class DeleteUserInteractor extends GetUserInteractor implements DeleteUserUseCase
{
    public function run($userID)
    {
        if ($this->getByID($userID))
            $this->userRepository->deleteUser($userID);
    }

}