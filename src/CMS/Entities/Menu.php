<?php

namespace CMS\Entities;

class Menu {

    private $identifier;
    private $items;
    private $name;

    public function __construct()
    {
        $this->items = array();
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function addItem(\CMS\Entities\MenuItem $item)
    {
        $this->items[]= $item;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

}