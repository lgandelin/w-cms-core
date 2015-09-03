<?php

namespace Webaccess\WCMSCore\Interactors\Users;

use Webaccess\WCMSCore\Context;

class GetUserInteractor
{
    public function getUserByID($userID, $structure = false)
    {
        if (!$user = Context::get('user')->findByID($userID)) {
            throw new \Exception('The user was not found');
        }

        return  ($structure) ? $user->toStructure() : $user;
    }
}
