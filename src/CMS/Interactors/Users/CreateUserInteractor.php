<?php

namespace CMS\Interactors\Users;

use CMS\Context;
use CMS\Entities\User;
use CMS\Structures\UserStructure;

class CreateUserInteractor
{
    public function run(UserStructure $userStructure)
    {
        $user = new User();
        $user->setInfos($userStructure);
        $user->valid();

        if ($this->anotherUserExistsWithSameLogin($user->getLogin())) {
            throw new \Exception('There is already a user with the same login');
        }

        return Context::getRepository('user')->createUser($user);
    }

    private function anotherUserExistsWithSameLogin($userLogin)
    {
        return Context::getRepository('user')->findByLogin($userLogin);
    }
}
