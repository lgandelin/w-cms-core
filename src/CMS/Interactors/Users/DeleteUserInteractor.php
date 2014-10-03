<?php

namespace CMS\Interactors\Users;

class DeleteUserInteractor extends GetUserInteractor
{
    public function run($userID)
    {
        if ($this->getByID($userID))
            $this->repository->deleteUser($userID);
    }

}