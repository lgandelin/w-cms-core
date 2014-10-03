<?php

namespace CMS\Interactors\Users;

use CMS\Structures\UserStructure;

class UpdateUserInteractor extends GetUserInteractor
{
    public function run($userID, UserStructure $userStructure)
    {
        if ($user = $this->getByID($userID)) {
            
            if (isset($userStructure->login) && $userStructure->login !== null && $user->getLogin() != $userStructure->login) $user->setLogin($userStructure->login);
            if (isset($userStructure->password) && $userStructure->password !== null && $user->getPassword() != $userStructure->password) $user->setPassword($userStructure->password);
            if (isset($userStructure->last_name) && $userStructure->last_name !== null && $user->getLastName() != $userStructure->last_name) $user->setLastName($userStructure->last_name);
            if (isset($userStructure->first_name) && $userStructure->first_name !== null && $user->getFirstName() != $userStructure->first_name) $user->setFirstName($userStructure->first_name);
            if (isset($userStructure->email) && $userStructure->email !== null && $user->getEmail() != $userStructure->email) $user->setEmail($userStructure->email);

            if ($user->valid()) {
                if ($this->anotherUserExistsWithSameLogin($userID, $user->getLogin()))
                    throw new \Exception('There is already a user with the same login');

                $this->repository->updateUser($user);
            }
        }
    }

    public function anotherUserExistsWithSameLogin($userID, $userLogin)
    {
        $user = $this->repository->findByLogin($userLogin);

        return ($user && $user->getID() != $userID);
    }

}