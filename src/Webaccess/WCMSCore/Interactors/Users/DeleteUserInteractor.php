<?php

namespace Webaccess\WCMSCore\Interactors\Users;

use Webaccess\WCMSCore\Context;

class DeleteUserInteractor extends GetUserInteractor
{
    public function run($userID)
    {
        if ($this->getUserByID($userID)) {
            Context::get('user_repository')->deleteUser($userID);
        }
    }
}
