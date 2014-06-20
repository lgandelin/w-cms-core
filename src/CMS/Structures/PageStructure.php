<?php

namespace CMS\Structures;

class PageStructure {

    public $name;
    public $uri;
    public $identifier;
    public $text;
    public $website;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;

    public function __construct($parameters = array())
    {
        foreach ($parameters as $key => $value) {
            if (property_exists($this, $key))
               $this->$key = $value;
        }
    }
} 