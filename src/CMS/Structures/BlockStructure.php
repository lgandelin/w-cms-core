<?php

namespace CMS\Structures;

class BlockStructure extends DataStructure
{
    public $ID;
    public $name;
    public $width;
    public $height;
    public $class;
    public $order;
    public $type;
    public $area_id;
    public $display;
    public $is_global;
    public $is_master;
    public $master_block_id;
    public $is_ghost;

    public static function toStructure($block)
    {
        $blockStructure = $block->getStructure();

        $blockStructure->ID = $block->getID();
        $blockStructure->name = $block->getName();
        $blockStructure->width = $block->getWidth();
        $blockStructure->height = $block->getHeight();
        $blockStructure->class = $block->getClass();
        $blockStructure->order = $block->getOrder();
        $blockStructure->type = $block->getType();
        $blockStructure->area_id = $block->getAreaID();
        $blockStructure->display = $block->getDisplay();
        $blockStructure->is_global = $block->getIsGlobal();
        $blockStructure->is_master = $block->getIsMaster();
        $blockStructure->master_block_id = $block->getMasterBlockID();
        $blockStructure->is_ghost = $block->getIsGhost();

        return $blockStructure;
    }
}
