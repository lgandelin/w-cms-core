<?php

namespace CMS\Structures;

class MenuStructure {

    public $identifier;
    public $items;
    public $name;

    public function __construct($parameters = array())
    {
        foreach ($parameters as $key => $value) {
            if (property_exists($this, $key))
                $this->$key = $value;
        }
    }
} 