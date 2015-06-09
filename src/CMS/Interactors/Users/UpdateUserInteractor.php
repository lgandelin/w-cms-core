<?php

namespace CMS\Interactors\Users;

use CMS\Context;
use CMS\Structures\UserStructure;

class UpdateUserInteractor extends GetUserInteractor
{
    public function run($userID, UserStructure $userStructure)
    {
        if ($user = $this->getUserByID($userID)) {
            $user->setInfos($userStructure);
            $user->valid();

            if ($this->anotherUserExistsWithSameLogin($userID, $user->getLogin())) {
                throw new \Exception('There is already a user with the same login');
            }

            Context::getRepository('user')->updateUser($user);
        }
    }

    private function anotherUserExistsWithSameLogin($userID, $userLogin)
    {
        $user = Context::getRepository('user')->findByLogin($userLogin);

        return ($user && $user->getID() != $userID);
    }
}
