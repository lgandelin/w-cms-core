<?php

namespace CMS\Entities;

use CMS\Structures\BlockStructure;

abstract class Block
{
    private $ID;
    private $name;
    private $width;
    private $height;
    private $class;
    private $order;
    private $type;
    private $areaID;
    private $display;
    private $isGlobal;
    private $masterBlockID;
    private $isMaster;
    private $isGhost;

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

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getAreaID()
    {
        return $this->areaID;
    }

    public function setAreaID($areaID)
    {
        $this->areaID = $areaID;
    }

    public function setDisplay($display)
    {
        $this->display = $display;
    }

    public function getDisplay()
    {
        return $this->display;
    }

    public function setIsGlobal($isGlobal)
    {
        $this->isGlobal = $isGlobal;
    }

    public function getIsGlobal()
    {
        return $this->isGlobal;
    }

    public function setIsMaster($isMaster)
    {
        $this->isMaster = $isMaster;
    }

    public function getIsMaster()
    {
        return $this->isMaster;
    }

    public function setMasterBlockID($blockID)
    {
        $this->masterBlockID = $blockID;
    }

    public function getMasterBlockID()
    {
        return $this->masterBlockID;
    }

    public function setIsGhost($isGhost)
    {
        $this->isGhost = $isGhost;
    }

    public function getIsGhost()
    {
        return $this->isGhost;
    }

    public function valid()
    {
        if (!$this->getName()) {
            throw new \InvalidArgumentException('You must provide a name for a block');
        }
    }

    public function setInfos(BlockStructure $blockStructure)
    {
        $properties = get_object_vars($blockStructure);
        foreach ($properties as $property => $value) {

            $method = ucfirst(str_replace('_', '', $property));
            $getter = 'get' . $method;
            $setter = 'set' . $method;

            if (
                isset($blockStructure->$property) &&
                property_exists(get_parent_class($blockStructure), $property) &&
                $blockStructure->$property !== null &&
                $blockStructure->$property != call_user_func_array(array($this, $getter), array())
            ) {
                call_user_func_array(array($this, $setter), array($value));
            }
        }

        return $this;
    }

    abstract public function getStructure();

    abstract public function updateContent(BlockStructure $blockStructure);
}
