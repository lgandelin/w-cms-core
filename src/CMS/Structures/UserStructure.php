<?php

namespace CMS\Structures;

class UserStructure {

    public $login;
    public $password;
    public $last_name;
    public $first_name;
    public $email;

    public function __construct($parameters = array())
    {
        foreach ($parameters as $key => $value) {
            if (property_exists($this, $key))
                $this->$key = $value;
        }
    }
} 