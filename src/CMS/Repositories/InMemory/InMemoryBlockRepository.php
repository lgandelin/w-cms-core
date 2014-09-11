<?php

namespace CMS\Repositories\InMemory;

use CMS\Entities\Block;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Repositories\BlockRepositoryInterface;
use CMS\Structures\BlockStructure;

class InMemoryBlockRepository implements BlockRepositoryInterface {

    private $blocks;

    public function __construct()
    {
        $this->blocks = [];
    }

    public function findByID($blockID)
    {
        foreach ($this->blocks as $block)
            if ($block->getID() == $blockID)
                return $block;

        return false;
    }

    public function findAll()
    {
        return $this->blocks;
    }

    public function findByAreaID($areaID)
    {
        $blocks = array();
        foreach ($this->blocks as $block)
            if ($block->getAreaID() == $areaID)
                $blocks[]= $block;
        return $blocks;
    }

    public function createBlock(BlockStructure $blockStructure)
    {
        if ($blockStructure->type == 'html')
            $block = new HTMLBlock();
        else
            $block = new Block();

        $block->setID($blockStructure->ID);
        $block->setName($blockStructure->name);
        $block->setWidth($blockStructure->width);
        $block->setHeight($blockStructure->height);
        $block->setClass($blockStructure->class);
        $block->setAreaID($blockStructure->area_id);
        $block->setType($blockStructure->type);

        if ($blockStructure->type == 'html')
            $block->setHTML($blockStructure->html);

        $this->blocks[]= $block;
    }

    public function updateBlock($blockID, BlockStructure $blockStructure)
    {
        foreach ($this->blocks as $block) {
            if ($block->getID() == $blockID) {
                $block->setName($blockStructure->name);
                $block->setWidth($blockStructure->width);
                $block->setHeight($blockStructure->height);
                $block->setClass($blockStructure->class);
            }
        }
    }

    public function deleteBlock($blockID)
    {
        foreach ($this->blocks as $i => $block)
            if ($block->getID() == $blockID)
                unset($this->blocks[$i]);
    }
} 