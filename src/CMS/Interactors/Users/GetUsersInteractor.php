<?php

namespace CMS\Interactors\Users;

use CMS\Context;

class GetUsersInteractor
{
    public function getAll($structure = false)
    {
        $users = Context::getRepository('user')->findAll();

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
