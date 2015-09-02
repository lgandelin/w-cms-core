<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Menu;
use Webaccess\WCMSCore\Entities\MenuItem;
use Webaccess\WCMSCore\Interactors\Menus\DuplicateMenuInteractor;

class DuplicateMenuInteractorTest extends PHPUnit_Framework_TestCase
{
    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new DuplicateMenuInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testDuplicateNonExistingMenu()
    {
        $this->interactor->run(2);
    }

    public function testDuplicateMenu()
    {
        $this->createSampleMenu();
        $this->assertCount(1, Context::get('menu')->findAll());

        $this->interactor->run(1);

        $this->assertCount(2, Context::get('menu')->findAll());
        $menuDuplicated = Context::get('menu')->findByIdentifier('test-menu-copy');
        $this->assertInstanceOf('\Webaccess\WCMSCore\Entities\Menu', $menuDuplicated);

        $this->assertEquals($menuDuplicated->getName(), 'Test menu - COPY');
        $this->assertEquals($menuDuplicated->getIdentifier(), 'test-menu-copy');
    }

    public function testDuplicateMenuAlongWithMenuItems()
    {
        $this->createSampleMenu();
        $this->createSampleMenuItem(1);
        $this->createSampleMenuItem(2);
        $this->createSampleMenuItem(3);
        $this->assertCount(1, Context::get('menu')->findAll());
        $this->assertCount(3, Context::get('menu_item')->findByMenuID(1));

        $this->interactor->run(1);

        $this->assertCount(2, Context::get('menu')->findAll());
        $menuDuplicated = Context::get('menu')->findByIdentifier('test-menu-copy');
        $this->assertCount(3, Context::get('menu_item')->findByMenuID($menuDuplicated->getID()));
    }
    
    private function createSampleMenu()
    {
        $menu = new Menu();
        $menu->setID(1);
        $menu->setName('Test menu');
        $menu->setIdentifier('test-menu');

        Context::get('menu')->createMenu($menu);

        return $menu;
    }

    private function createSampleMenuItem($menuItemID)
    {
        $menuItem = new MenuItem();
        $menuItem->setID($menuItemID);
        $menuItem->setMenuID(1);
        $menuItem->setLabel('Test menu item');
        $menuItem->setOrder(999);

        Context::get('menu_item')->createMenuItem($menuItem);
    }
}