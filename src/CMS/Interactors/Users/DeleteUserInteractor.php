<?php

namespace CMS\Interactors\Users;

use CMS\Context;

class DeleteUserInteractor extends GetUserInteractor
{
    public function run($userID)
    {
        if ($this->getUserByID($userID)) {
            Context::get('user')->deleteUser($userID);
        }
    }
}
