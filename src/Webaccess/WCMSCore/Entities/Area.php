<?php

namespace Webaccess\WCMSCore\Entities;

class Area extends Entity
{
    private $ID;
    private $name;
    private $width;
    private $height;
    private $class;
    private $order;
    private $pageID;
    private $display;
    private $isMaster;
    private $masterAreaID;

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

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setPageID($pageID)
    {
        $this->pageID = $pageID;
    }

    public function getPageID()
    {
        return $this->pageID;
    }

    public function setDisplay($display)
    {
        $this->display = $display;
    }

    public function getDisplay()
    {
        return $this->display;
    }

    public function setIsMaster($isMaster)
    {
        $this->isMaster = $isMaster;
    }

    public function getIsMaster()
    {
        return $this->isMaster;
    }

    public function setMasterAreaID($masterAreaID)
    {
        $this->masterAreaID = $masterAreaID;
    }

    public function getMasterAreaID()
    {
        return $this->masterAreaID;
    }

    public function valid()
    {
        if (!$this->getName()) {
            throw new \InvalidArgumentException('You must provide a name for an area');
        }

        return true;
    }
}
