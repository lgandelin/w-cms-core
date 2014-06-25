<?php

namespace CMS\Structures;

use CMS\Entities\User;
use CMS\Structures\DataStructure;

class UserStructure extends DataStructure {

    public $login;
    public $password;
    public $last_name;
    public $first_name;
    public $email;

    public static function convertUserToUserStructure(User $user)
    {
        return new UserStructure([
            'login' => $user->getLogin(),
            'password' => $user->getPassword(),
            'last_name' => $user->getLastName(),
            'first_name' => $user->getFirstName(),
            'email' => $user->getEmail()
        ]);
    }

    public static function convertUserStructureToUser(UserStructure $userStructure)
    {
        $user = new User();
        $user->setLogin($userStructure->login);
        if ($userStructure->password != null && $userStructure->password != $user->getPassword())
            $user->setPassword($userStructure->password);
        $user->setLastName($userStructure->last_name);
        $user->setFirstName($userStructure->first_name);
        $user->setEmail($userStructure->email);

        return $user;
    }
} 