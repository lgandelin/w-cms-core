<?php

namespace CMS\Entities;

use CMS\Entities\MenuItem;

class Menu {

    private $ID;
    private $identifier;
    private $items;
    private $name;

    public function __construct()
    {
        $this->items = [];
    }

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

    public function addItem(MenuItem $item)
    {
        $this->items[$item->getID()]= $item;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function updateItem($menuItemID, $menuItem)
    {
        $this->items[$menuItemID]= $menuItem;
    }

    public function deleteItem($menuItemID)
    {
        unset($this->items[$menuItemID]);
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

    public function valid()
    {
        if (!$this->getIdentifier())
            throw new \InvalidArgumentException('You must provide an identifier for a menu');

        return true;
    }

}