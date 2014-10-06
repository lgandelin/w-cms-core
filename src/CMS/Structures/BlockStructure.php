<?php

namespace CMS\Structures;

use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\Blocks\MenuBlockStructure;
use CMS\Structures\Blocks\ViewFileBlockStructure;

class BlockStructure extends DataStructure {

    public $ID;
    public $name;
    public $width;
    public $height;
    public $class;
    public $order;
    public $type;
    public $area_id;
    public $display;

    public static function toStructure($block)
    {
        if ($block->getType() == 'html') {
            $blockStructure = new HTMLBlockStructure();
            $blockStructure->html = $block->getHTML();
        } elseif ($block->getType() == 'menu') {
            $blockStructure = new MenuBlockStructure();
            $blockStructure->menu_id = $block->getMenuID();
        } elseif ($block->getType() == 'view_file') {
            $blockStructure = new ViewFileBlockStructure();
            $blockStructure->view_file = $block->getViewFile();
        } else
            $blockStructure = new BlockStructure();

        $blockStructure->ID = $block->getID();
        $blockStructure->name = $block->getName();
        $blockStructure->width = $block->getWidth();
        $blockStructure->height = $block->getHeight();
        $blockStructure->class = $block->getClass();
        $blockStructure->order = $block->getOrder();
        $blockStructure->type = $block->getType();
        $blockStructure->area_id = $block->getAreaID();
        $blockStructure->display = $block->getDisplay();

        return $blockStructure;
    }
}