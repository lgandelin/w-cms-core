<?php

namespace CMS\Interactors\Users;

use CMS\Context;

class GetUserInteractor
{
    public function getUserByID($userID, $structure = false)
    {
        if (!$user = Context::getRepository('user')->findByID($userID)) {
            throw new \Exception('The user was not found');
        }

        return  ($structure) ? $user->toStructure() : $user;
    }
}
