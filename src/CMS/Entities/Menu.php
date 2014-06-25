<?php

namespace CMS\Entities;

use CMS\Entities\MenuItem;

class Menu {

    private $identifier;
    private $items;
    private $name;

    public function __construct()
    {
        $this->items = [];
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function addItem(MenuItem $item)
    {
        $this->items[]= $item;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function deleteItems()
    {
        $this->items = [];
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