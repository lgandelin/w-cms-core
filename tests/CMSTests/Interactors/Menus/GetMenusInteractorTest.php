<?php

use CMS\Context;
use CMS\Entities\Menu;
use CMS\Interactors\Menus\GetMenusInteractor;

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
        $this->assertInstanceOf('\CMS\Entities\Menu', array_shift($menus));
    }

    public function testGetAllByStructures()
    {
        $this->createSampleMenu(1);
        $this->createSampleMenu(1);

        $menus = $this->interactor->getAll(null, true);
        $this->assertCount(2, $menus);
        $this->assertInstanceOf('\CMS\Structures\DataStructure', array_shift($menus));
    }

    private function createSampleMenu($menuID)
    {
        $menu = new Menu();
        $menu->setID($menuID);
        $menu->setName('Test menu');
        $menu->setIdentifier('test-menu');

        Context::getRepository('menu')->createMenu($menu);

        return $menu;
    }
}
