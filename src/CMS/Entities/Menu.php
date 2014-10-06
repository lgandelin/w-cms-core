<?php

namespace CMS\Entities;

class Menu
{
    private $ID;
    private $identifier;
    private $name;

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getID()
    {
        return $this->ID;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function valid()
    {
        if (!$this->getIdentifier())
            throw new \InvalidArgumentException('You must provide an identifier for a menu');

        return true;
    }
}