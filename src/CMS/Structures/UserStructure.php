<?php

namespace CMS\Structures;

use CMS\Entities\User;

class UserStructure extends DataStructure {

    public $ID;
    public $login;
    public $password;
    public $last_name;
    public $first_name;
    public $email;

    public static function toStructure(User $user)
    {
        $userStructure = new UserStructure();
        $userStructure->ID = $user->getID();
        $userStructure->login = $user->getLogin();
        $userStructure->email = $user->getEmail();
        $userStructure->password = $user->getPassword();
        $userStructure->last_name = $user->getLastName();
        $userStructure->first_name = $user->getFirstName();

        return $userStructure;
    }
}