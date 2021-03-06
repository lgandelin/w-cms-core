<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\MenuItem;
use Webaccess\WCMSCore\Interactors\MenuItems\GetMenuItemsInteractor;

class GetMenuItemsInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetMenuItemsInteractor(Context::get('menu_item_repository'));
    }

    public function testGetAllWithoutMenuItems()
    {
        $this->assertCount(0, $this->interactor->getAll(1));
    }

    public function testGetAll()
    {
        $this->createSampleMenuItem(1);
        $this->createSampleMenuItem(2);

        $menus = $this->interactor->getAll(1);
        $this->assertCount(2, $menus);
        $this->assertInstanceOf('\Webaccess\WCMSCore\Entities\MenuItem', $menus[0]);
    }

    public function testGetAllByStructures()
    {
        $this->createSampleMenuItem(1);
        $this->createSampleMenuItem(2);

        $menus = $this->interactor->getAll(1, true);
        $this->assertCount(2, $menus);
        $this->assertInstanceOf('\Webaccess\WCMSCore\DataStructure', $menus[0]);
    }

    private function createSampleMenuItem($menuItemID)
    {
        $menu = new MenuItem();
        $menu->setID($menuItemID);
        $menu->setMenuID(1);
        $menu->setLabel('Test menu item');
        $menu->setOrder(999);

        Context::get('menu_item_repository')->createMenuItem($menu);

        return $menu;
    }
}
