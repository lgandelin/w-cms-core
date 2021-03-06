<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Menu;
use Webaccess\WCMSCore\Interactors\Menus\GetMenusInteractor;

class GetAllMenusInteractorTest extends PHPUnit_Framework_TestCase
{
    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetMenusInteractor();
    }

    public function testGetAllWithoutMenus()
    {
        $this->assertCount(0, $this->interactor->getAll());
    }

    public function testGetAll()
    {
        $this->createSampleMenu(1);
        $this->createSampleMenu(2);

        $menus = $this->interactor->getAll();
        $this->assertCount(2, $menus);
        $this->assertInstanceOf('\Webaccess\WCMSCore\Entities\Menu', array_shift($menus));
    }

    public function testGetAllByStructures()
    {
        $this->createSampleMenu(1);
        $this->createSampleMenu(1);

        $menus = $this->interactor->getAll(null, true);
        $this->assertCount(2, $menus);
        $this->assertInstanceOf('\Webaccess\WCMSCore\DataStructure', array_shift($menus));
    }

    private function createSampleMenu($menuID)
    {
        $menu = new Menu();
        $menu->setID($menuID);
        $menu->setName('Test menu');
        $menu->setIdentifier('test-menu');

        Context::get('menu_repository')->createMenu($menu);

        return $menu;
    }
}
