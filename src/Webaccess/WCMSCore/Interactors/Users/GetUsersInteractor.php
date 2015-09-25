<?php

namespace Webaccess\WCMSCore\Interactors\Users;

use Webaccess\WCMSCore\Context;

class GetUsersInteractor
{
    public function getAll($structure = false)
    {
        $users = Context::get('user_repository')->findAll();

        return ($structure) ? $this->getUserStructures($users) : $users;
    }

    private function getUserStructures($users)
    {
        return array_map(function($user) {
            return $user->toStructure();
        }, $users);
    }
}
