<?php

namespace CMS\Entities;

use CMS\Entities\Page;

class MenuItem {

    private $ID;
    private $label;
    private $page;
    private $order;

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function valid()
    {
        if (!is_int($this->getOrder()))
            throw new \InvalidArgumentException('You must provide an integer for the menu item order');

        if (!$this->getLabel())
            throw new \InvalidArgumentException('You must provide a label for the menu item');

        return true;
    }

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getID()
    {
        return $this->ID;
    }

}