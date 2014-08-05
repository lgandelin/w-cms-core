<?php

namespace CMS\Structures;

use CMS\Structures\DataStructure;

class UserStructure extends DataStructure {

    public $ID;
    public $login;
    public $password;
    public $last_name;
    public $first_name;
    public $email;
}