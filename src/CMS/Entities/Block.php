<?php

namespace CMS\Entities;

use CMS\Structures\BlockStructure;

class Block
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

    public function getStructure()
    {
        return new BlockStructure();
    }

    public function setInfos(BlockStructure $blockStructure)
    {
        if ($blockStructure->name !== null && $blockStructure->name != $this->getName()) {
            $this->setName($blockStructure->name);
        }

        if ($blockStructure->width !== null && $blockStructure->width != $this->getWidth()) {
            $this->setWidth($blockStructure->width);
        }

        if ($blockStructure->height !== null && $blockStructure->height != $this->getHeight()) {
            $this->setHeight($blockStructure->height);
        }

        if ($blockStructure->class !== null && $blockStructure->class != $this->getClass()) {
            $this->setClass($blockStructure->class);
        }

        if ($blockStructure->order !== null && $blockStructure->order != $this->getOrder()) {
            $this->setOrder($blockStructure->order);
        }

        if (isset($blockStructure->area_id) && $blockStructure->area_id !== null && $blockStructure->area_id != $this->getAreaId()) {
            $this->setAreaID($blockStructure->area_id);
        }

        if ($blockStructure->display !== null && $blockStructure->display != $this->getDisplay()) {
            $this->setDisplay($blockStructure->display);
        }

        if ($blockStructure->is_global !== null && $blockStructure->is_global != $this->getIsGlobal()) {
            $this->setIsGlobal($blockStructure->is_global);
        }

        if ($blockStructure->master_block_id !== null && $blockStructure->master_block_id != $this->getMasterBlockID()) {
            $this->setMasterBlockID($blockStructure->master_block_id);
        }

        if ($blockStructure->is_ghost !== null && $blockStructure->is_ghost != $this->getIsGhost()) {
            $this->setIsGhost($blockStructure->is_ghost);
        }

        if (isset($blockStructure->is_master) && $blockStructure->is_master !== null && $blockStructure->is_master != $this->getIsMaster()) {
            $this->setIsMaster($blockStructure->is_master);
        }
        
        return $this;
    }

    public function updateContent()
    {

    }
}
