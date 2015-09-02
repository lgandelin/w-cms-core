<?php

namespace Webaccess\WCMSCore\Entities;

class Theme extends Entity
{
    private $ID;
    private $identifier;
    private $is_selected;

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getID()
    {
        return $this->ID;
    }

    public function setIsSelected($is_selected)
    {
        $this->is_selected = $is_selected;
    }

    public function getIsSelected()
    {
        return $this->is_selected;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }
}