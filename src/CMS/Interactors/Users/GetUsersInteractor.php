<?php

namespace CMS\Interactors\Users;

use CMS\Context;
use CMS\Structures\UserStructure;

class GetUsersInteractor
{
    public function getAll($structure = false)
    {
        $users = Context::$userRepository->findAll();

        return ($structure) ? $this->getUserStructures($users) : $users;
    }

    private function getUserStructures($users)
    {
        $userStructures = [];
        if (is_array($users) && sizeof($users) > 0) {
            foreach ($users as $user) {
                $userStructures[] = UserStructure::toStructure($user);
            }
        }

        return $userStructures;
    }
}
