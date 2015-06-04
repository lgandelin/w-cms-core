<?php

namespace CMS\Interactors\Users;

use CMS\Context;
use CMS\Structures\UserStructure;

class GetUserInteractor
{
    public function getUserByID($userID, $structure = false)
    {
        if (!$user = Context::$userRepository->findByID($userID)) {
            throw new \Exception('The user was not found');
        }

        return  ($structure) ? UserStructure::toStructure($user) : $user;
    }
}
