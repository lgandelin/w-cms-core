<?php

namespace Webaccess\WCMSCore\Entities;

class MenuItem extends Entity
{
    private $ID;
    private $label;
    private $pageID;
    private $externalURL;
    private $order;
    private $class;
    private $display;
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

    public function setExternalURL($externalURL)
    {
        $this->externalURL = $externalURL;
    }

    public function getExternalURL()
    {
        return $this->externalURL;
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

    public function setClass($class)
    {
        $this->class = $class;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setDisplay($display)
    {
        $this->display = $display;
    }

    public function getDisplay()
    {
        return $this->display;
    }

    public function valid()
    {
        if (!is_int($this->getOrder())) {
            throw new \InvalidArgumentException('You must provide an integer for the menu item order');
        }

        if (!$this->getLabel()) {
            throw new \InvalidArgumentException('You must provide a label for the menu item');
        }

        return true;
    }
}
