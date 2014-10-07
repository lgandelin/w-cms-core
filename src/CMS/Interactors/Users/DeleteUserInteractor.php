<?php

namespace CMS\Interactors\Users;

class DeleteUserInteractor extends GetUserInteractor
{
    public function run($userID)
    {
        if ($this->getUserByID($userID))
            $this->repository->deleteUser($userID);
    }
}