<?php

namespace Webaccess\WCMSCore\Interactors\Users;

use Webaccess\WCMSCore\Context;

class GetUserInteractor
{
    public function getUserByID($userID, $structure = false)
    {
        if (!$user = Context::get('user_repository')->findByID($userID)) {
            throw new \Exception('The user was not found');
        }

        return  ($structure) ? $user->toStructure() : $user;
    }

    public function getUserByLogin($userLogin, $structure = false)
    {
        if (!$user = Context::get('user_repository')->findByLogin($userLogin)) {
            throw new \Exception('The user was not found');
        }

        return  ($structure) ? $user->toStructure() : $user;
    }
}
