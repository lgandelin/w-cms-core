<?php

namespace CMS\Structures;

class AreaStructure extends DataStructure
{
    public $ID;
    public $name;
    public $width;
    public $height;
    public $class;
    public $order;
    public $page_id;
    public $display;
    public $is_master;
    public $master_area_id;

    public static function toStructure($area)
    {
        $areaStructure = new AreaStructure();
        $areaStructure->ID = $area->getID();
        $areaStructure->name = $area->getName();
        $areaStructure->width = $area->getWidth();
        $areaStructure->height = $area->getHeight();
        $areaStructure->class = $area->getClass();
        $areaStructure->order = $area->getOrder();
        $areaStructure->page_id = $area->getPageID();
        $areaStructure->display = $area->getDisplay();
        $areaStructure->is_master = $area->getIsMaster();
        $areaStructure->master_area_id = $area->getMasterAreaID();

        return $areaStructure;
    }
}
