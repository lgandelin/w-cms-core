<?php

namespace CMS\Interactors\Users;

use CMS\Converters\UserConverter;
use CMS\Structures\UserStructure;
use CMS\UseCases\Users\UpdateUserUseCase;

class UpdateUserInteractor extends GetUserInteractor implements UpdateUserUseCase
{
    public function run($userID, UserStructure $userStructure)
    {
        if ($originalUserStructure = $this->getByID($userID)) {
            $userUpdated = $this->getUserUpdated($originalUserStructure, $userStructure);

            if ($userUpdated->valid()) {
                if ($this->anotherUserExistsWithSameLogin($userID, $userUpdated->getLogin()))
                    throw new \Exception('There is already a user with the same login');

                $this->userRepository->updateUser($userID, UserConverter::convertUserToUserStructure($userUpdated));
            }
        }
    }

    public function getUserUpdated(UserStructure $originalUserStructure, UserStructure $userStructure)
    {
        $user = UserConverter::convertUserStructureToUser($originalUserStructure);

        if (isset($userStructure->login) && $userStructure->login !== null && $user->getLogin() != $userStructure->login) $user->setLogin($userStructure->login);
        if (isset($userStructure->password) && $userStructure->password !== null && $user->getPassword() != $userStructure->password) $user->setPassword($userStructure->password);
        if (isset($userStructure->last_name) && $userStructure->last_name !== null && $user->getLastName() != $userStructure->last_name) $user->setLastName($userStructure->last_name);
        if (isset($userStructure->first_name) && $userStructure->first_name !== null && $user->getFirstName() != $userStructure->first_name) $user->setFirstName($userStructure->first_name);
        if (isset($userStructure->email) && $userStructure->email !== null && $user->getEmail() != $userStructure->email) $user->setEmail($userStructure->email);

        return $user;
    }

    public function anotherUserExistsWithSameLogin($userID, $userLogin)
    {
        $existingUserStructure = $this->userRepository->findByLogin($userLogin);

        return ($existingUserStructure && $existingUserStructure->ID != $userID);
    }

}