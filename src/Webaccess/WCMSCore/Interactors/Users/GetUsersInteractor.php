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
        $userStructures = [];
        if (is_array($users) && sizeof($users) > 0) {
            foreach ($users as $user) {
                $userStructures[] = $user->toStructure();
            }
        }

        return $userStructures;
    }
}
