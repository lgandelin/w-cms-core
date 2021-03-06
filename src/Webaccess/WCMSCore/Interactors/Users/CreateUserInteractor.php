<?php

namespace Webaccess\WCMSCore\Interactors\Users;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\User;
use Webaccess\WCMSCore\DataStructure;

class CreateUserInteractor
{
    public function run(DataStructure $userStructure)
    {
        $user = (new User())->setInfos($userStructure);
        $user->valid();

        if ($this->anotherUserExistsWithSameLogin($user->getLogin())) {
            throw new \Exception('There is already a user with the same login');
        }

        return Context::get('user_repository')->createUser($user);
    }

    private function anotherUserExistsWithSameLogin($userLogin)
    {
        return Context::get('user_repository')->findByLogin($userLogin);
    }
}
