<?php

namespace CMS\Fixtures;

use CMS\Context;
use CMS\Entities\Area;
use CMS\Entities\Block;
use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
use CMS\Entities\Page;

class PagesFixtures {

    public static function run()
    {
        $pageID = self::createSamplePage('Home page', 'home', '/', 1);
        $area1ID = self::createSampleArea('Header Area', 12, 1, 1, $pageID);
        $area2ID = self::createSampleArea('Content Area', 12, 1, 1, $pageID);
        self::createSampleMenu('Header Menu', 'header-menu', 1);

        self::createSampleBlock('Menu Block', 'menu', 12, 1, 1, $area1ID);
        self::createSampleBlock('HTML Block', 'html', 12, 1, 2, $area2ID);
        self::createSampleBlock('HTML Block 2', 'html', 6, 1, 3, $area2ID);
        self::createSampleBlock('HTML Block 3', 'html', 6, 1, 4, $area2ID);
    }

    private static function createSamplePage($name, $identifier, $uri, $langID)
    {
        $page = new Page();
        $page->setName($name);
        $page->setIdentifier($identifier);
        $page->setUri($uri);
        $page->setLangID($langID);

        return Context::get('page')->createPage($page);
    }

    private static function createSampleArea($name, $width, $height, $order, $pageID)
    {
        $area = new Area();
        $area->setName($name);
        $area->setWidth($width);
        $area->setHeight($height);
        $area->setOrder($order);
        $area->setDisplay(1);
        $area->setPageID($pageID);

        return Context::get('area')->createArea($area);
    }

    private static function createSampleBlock($name, $type, $width, $height, $order, $areaID)
    {
        $block = new Block();
        $block->setName($name);
        $block->setType($type);
        $block->setWidth($width);
        $block->setHeight($height);
        $block->setOrder($order);
        $block->setAreaID($areaID);
        $block->setDisplay(1);

        return Context::get('block')->createBlock($block);
    }

    private static function createSampleMenu($name, $identifier, $langID)
    {
        $menu = new Menu();
        $menu->setName($name);
        $menu->setIdentifier($identifier);
        $menu->setLangID($langID);

        for ($i = 0; $i < 3; $i++) {
            $menuItem = new MenuItem();
            $menuItem->setLabel('Item ' . $i);
            $menuItem->setOrder($i);
            $menuItem->setPageID(1);
            $menuItem->setMenuID($menu->getID());
            $menuItem->setDisplay(1);

            Context::get('menu_item')->createMenuItem($menuItem);
        }

        return Context::get('menu')->createMenu($menu);
    }
}