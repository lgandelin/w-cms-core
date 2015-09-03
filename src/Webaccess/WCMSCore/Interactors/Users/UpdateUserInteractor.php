<?php

namespace Webaccess\WCMSCore\Interactors\Users;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;

class UpdateUserInteractor extends GetUserInteractor
{
    public function run($userID, DataStructure $userStructure)
    {
        if ($user = $this->getUserByID($userID)) {
            $user->setInfos($userStructure);
            $user->valid();

            if ($this->anotherUserExistsWithSameLogin($userID, $user->getLogin())) {
                throw new \Exception('There is already a user with the same login');
            }

            Context::get('user')->updateUser($user);
        }
    }

    private function anotherUserExistsWithSameLogin($userID, $userLogin)
    {
        $user = Context::get('user')->findByLogin($userLogin);

        return ($user && $user->getID() != $userID);
    }
}
