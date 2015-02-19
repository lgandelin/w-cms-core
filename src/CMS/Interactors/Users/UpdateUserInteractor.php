<?php

namespace CMS\Interactors\Users;

use CMS\Structures\UserStructure;

class UpdateUserInteractor extends GetUserInteractor
{
    public function run($userID, UserStructure $userStructure)
    {
        if ($user = $this->getUserByID($userID)) {

            $properties = get_object_vars($userStructure);
            unset ($properties['ID']);
            foreach ($properties as $property => $value) {
                $method = ucfirst(str_replace('_', '', $property));
                $setter = 'set' . $method;

                if ($userStructure->$property !== null) {
                    call_user_func_array(array($user, $setter), array($value));
                }
            }

            $user->valid();

            if ($this->anotherUserExistsWithSameLogin($userID, $user->getLogin())) {
                throw new \Exception('There is already a user with the same login');
            }

            $this->repository->updateUser($user);
        }
    }

    private function anotherUserExistsWithSameLogin($userID, $userLogin)
    {
        $user = $this->repository->findByLogin($userLogin);

        return ($user && $user->getID() != $userID);
    }
}
