<?php

namespace CMS\Entities;

class MenuItem
{
    private $ID;
    private $label;
    private $pageID;
    private $order;
    private $menuID;

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getID()
    {
        return $this->ID;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setPageID($pageID)
    {
        $this->pageID = $pageID;
    }

    public function getPageID()
    {
        return $this->pageID;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setMenuID($menuID)
    {
        $this->menuID = $menuID;
    }

    public function getMenuID()
    {
        return $this->menuID;
    }

    public function valid()
    {
        if (!is_int($this->getOrder()))
            throw new \InvalidArgumentException('You must provide an integer for the menu item order');

        if (!$this->getLabel())
            throw new \InvalidArgumentException('You must provide a label for the menu item');

        return true;
    }
}