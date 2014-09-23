<?php

namespace CMS\Entities;

class Block {

    private $ID;
    private $name;
    private $width;
    private $height;
    private $class;
    private $type;
    private $areaID;

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getID()
    {
        return $this->ID;
    }

    public function setClass($class)
    {
        $this->class = $class;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getAreaID()
    {
        return $this->areaID;
    }

    public function setAreaID($areaID)
    {
        $this->areaID = $areaID;
    }

    public function valid()
    {
        return true;
    }
}