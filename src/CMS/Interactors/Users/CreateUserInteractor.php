<?php

namespace CMS\Interactors\Users;

use CMS\Context;
use CMS\Entities\User;
use CMS\Structures\UserStructure;

class CreateUserInteractor
{
    public function run(UserStructure $userStructure)
    {
        $user = $this->createUserFromStructure($userStructure);

        $user->valid();

        if ($this->anotherUserExistsWithSameLogin($user->getLogin())) {
            throw new \Exception('There is already a user with the same login');
        }

        return Context::$userRepository->createUser($user);
    }

    private function anotherUserExistsWithSameLogin($userLogin)
    {
        return Context::$userRepository->findByLogin($userLogin);
    }

    private function createUserFromStructure(UserStructure $userStructure)
    {
        $user = new User();
        $user->setLogin($userStructure->login);
        if ($userStructure->password != null && $userStructure->password != $user->getPassword()) {
            $user->setPassword($userStructure->password);
        }
        $user->setLastName($userStructure->last_name);
        $user->setFirstName($userStructure->first_name);
        $user->setEmail($userStructure->email);

        return $user;
    }
}
