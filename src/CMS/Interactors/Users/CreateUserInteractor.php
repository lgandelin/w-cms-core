<?php

namespace CMS\Interactors\Users;

use CMS\Entities\User;
use CMS\Repositories\UserRepositoryInterface;
use CMS\Structures\UserStructure;

class CreateUserInteractor
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(UserStructure $userStructure)
    {
        $user = $this->createUserFromStructure($userStructure);

        $user->valid();

        if ($this->anotherUserExistsWithSameLogin($user->getLogin())) {
            throw new \Exception('There is already a user with the same login');
        }

        return $this->repository->createUser($user);
    }

    private function anotherUserExistsWithSameLogin($userLogin)
    {
        return $this->repository->findByLogin($userLogin);
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
