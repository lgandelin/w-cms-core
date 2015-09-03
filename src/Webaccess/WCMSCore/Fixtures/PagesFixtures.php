<?php

namespace Webaccess\WCMSCore\Fixtures;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Entities\Blocks\MenuBlock;
use Webaccess\WCMSCore\Entities\Blocks\ViewBlock;
use Webaccess\WCMSCore\Entities\Menu;
use Webaccess\WCMSCore\Entities\MenuItem;
use Webaccess\WCMSCore\Entities\Page;

class PagesFixtures {

    public static function run()
    {
        $pageID = self::createPage('Home page', 'home', '/', 1);
        $area1ID = self::createArea('Header Area', 12, 1, 'header', 1, $pageID);
        $area2ID = self::createArea('Content Area', 12, 1, 'content', 1, $pageID);
        $menuID = self::createMenu('Main Menu', 'main-menu', 1, $pageID);

        self::createMenuBlock('Menu Block', 9, 1, 'navigation', 'left', 2, 'menu', $area1ID, $menuID);
        self::createHTMLBlock('Welcome to W CMS', 12, 1, 'welcome', 'center', 1, 'html', $area2ID, '<h1>Welcome to W CMS !</h1>');
        self::createHTMLBlock('Right block', 6, 1, 'right', 'left', 3, 'html', $area2ID, '<p>Aenean arcu eros, sodales cursus<strong> volutpat vitae</strong>, mattis ut arcu. Quisque nec sagittis arcu. Morbi tempor tortor eu tellus tristique, vitae condimentum sapien convallis. Quisque lacinia enim eros, sit amet dignissim arcu lobortis viverra. Morbi sed sapien fermentum, molestie augue id, elementum urna.</p>');
        self::createHTMLBlock('Left block', 6, 1, 'left', 'left', 2, 'html', $area2ID, '<p>Integer hendrerit sollicitudin dui a ultrices. Integer ullamcorper vel nisl sed luctus. Duis massa risus, <strong>porta sit amet venenatis</strong> in, scelerisque ut enim. Suspendisse rutrum mattis mauris in cursus. Etiam vel pellentesque justo. Donec interdum felis ac condimentum pretium.</p>');
        self::createHTMLBlock('Text block', 8, 1, '', 'left', 5, 'html', $area2ID, '<h2>Lorem ipsum dolor sit amet</h2><p>Consectetur adipiscing elit. Ut ut tortor ac libero convallis egestas. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec magna lorem, lacinia non lorem eget, egestas maximus leo. Donec ultrices pretium orci, in molestie eros auctor ut. Vivamus <a href="#">ac sem ut elit vulputate lobortis</a>. Curabitur ornare pharetra ex eu ultricies. Praesent tellus augue, vestibulum quis dictum quis, vehicula sed magna. Integer <strong>fermentum</strong> ante eu fermentum maximus. <strong>Vivamus</strong> tincidunt congue elit. Nam in venenatis odio, a ultricies mi. Quisque elementum, dui sit amet iaculis accumsan, <a href="#">tortor arcu dictum massa</a>, <strong>in venenatis felis</strong> augue ut leo. Vestibulum cursus turpis id justo interdum pellentesque. Proin ullamcorper accumsan mauris, quis dictum odio mollis quis.</p>');
        self::createViewBlock('File block', 4, 1, 'hello', 'left', 4, 'view', $area2ID, 'hello');
        self::createHTMLBlock('Text block', 12, 1, 'text', 'left', 6, 'html', $area2ID, '<p>In hac habitasse platea dictumst. Nam vel sem enim. Aenean nisl mauris, tristique at nibh et, elementum semper metus. Donec blandit aliquet tortor pharetra imperdiet. Maecenas placerat tincidunt felis, vehicula tempor ante malesuada sed. Maecenas faucibus sapien eget mi convallis iaculis. Morbi nulla felis, fermentum non porta eget, porttitor eget tellus. Sed quis lorem vel neque fringilla luctus a quis turpis. Praesent pulvinar rutrum suscipit. Nullam lacinia molestie lorem at gravida. Aliquam gravida interdum arcu id gravida.</p>');
        self::createHTMLBlock('Logo', 3, 1, 'logo', 'left', 1, 'html', $area1ID, '<img src="http://web-access.fr/w-cms-logo.png" alt="logo" title="logo">');
    }

    private static function createPage($name, $identifier, $uri, $langID)
    {
        $page = new Page();
        $page->setName($name);
        $page->setIdentifier($identifier);
        $page->setUri($uri);
        $page->setLangID($langID);

        return Context::get('page')->createPage($page);
    }

    private static function createArea($name, $width, $height, $class, $order, $pageID)
    {
        $area = new Area();
        $area->setName($name);
        $area->setWidth($width);
        $area->setHeight($height);
        $area->setClass($class);
        $area->setOrder($order);
        $area->setDisplay(1);
        $area->setPageID($pageID);

        return Context::get('area')->createArea($area);
    }
    private static function createHTMLBlock($name, $width, $height, $class, $alignment, $order, $type, $areaID, $html)
    {
        $block = new HTMLBlock();
        $block->setName($name);
        $block->setWidth($width);
        $block->setHeight($height);
        $block->setClass($class);
        $block->setAlignment($alignment);
        $block->setOrder($order);
        $block->setType($type);
        $block->setAreaID($areaID);
        $block->setDisplay(1);
        $block->setHTML($html);

        return Context::get('block')->createBlock($block);
    }

    private static function createViewBlock($name, $width, $height, $class, $alignment, $order, $type, $areaID, $viewPath)
    {
        $block = new ViewBlock();
        $block->setName($name);
        $block->setWidth($width);
        $block->setHeight($height);
        $block->setClass($class);
        $block->setAlignment($alignment);
        $block->setOrder($order);
        $block->setType($type);
        $block->setAreaID($areaID);
        $block->setDisplay(1);
        $block->setViewPath($viewPath);

        return Context::get('block')->createBlock($block);
    }

    private static function createMenu($name, $identifier, $langID, $pageID)
    {
        $menu = new Menu();
        $menu->setName($name);
        $menu->setIdentifier($identifier);
        $menu->setLangID($langID);
        $menuID = Context::get('menu')->createMenu($menu);

        for ($i = 0; $i < 3; $i++) {
            $menuItem = new MenuItem();
            $menuItem->setLabel('Item ' . ($i + 1));
            $menuItem->setOrder($i);
            $menuItem->setPageID($pageID);
            $menuItem->setMenuID($menuID);
            $menuItem->setDisplay(1);

            Context::get('menu_item')->createMenuItem($menuItem);
        }

        return $menuID;
    }

    private static function createMenuBlock($name, $width, $height, $class, $alignment, $order, $type, $areaID, $menuID)
    {
        $block = new MenuBlock();
        $block->setName($name);
        $block->setWidth($width);
        $block->setHeight($height);
        $block->setClass($class);
        $block->setAlignment($alignment);
        $block->setOrder($order);
        $block->setType($type);
        $block->setAreaID($areaID);
        $block->setDisplay(1);
        $block->setMenuID($menuID);

        return Context::get('block')->createBlock($block);
    }
}