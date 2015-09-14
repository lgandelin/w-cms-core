<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Menu;
use Webaccess\WCMSCore\Entities\MenuItem;
use Webaccess\WCMSCore\Interactors\MenuItems\DeleteMenuItemInteractor;

class DeleteMenuItemInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new DeleteMenuItemInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingMenuItem()
    {
        $this->interactor->run(2);
    }

    public function testDeleteItem()
    {
        $this->createSampleMenu();
        $this->createSampleMenuItem();

        $this->assertEquals(1, count(Context::get('menu_item_repository')->findByMenuID(1)));

        //Delete the item
        $this->interactor->run(1);

        $this->assertEquals(0, count(Context::get('menu_item_repository')->findByMenuID(1)));
    }

    private function createSampleMenu()
    {
        $menu = new Menu();
        $menu->setID(1);
        $menu->setName('Test menu');
        $menu->setIdentifier('test-menu');

        Context::get('menu_repository')->createMenu($menu);

        return $menu;
    }

    private function createSampleMenuItem()
    {
        $menuItem = new MenuItem();
        $menuItem->setID(1);
        $menuItem->setMenuID(1);
        $menuItem->setLabel('Test menu item');

        Context::get('menu_item_repository')->createMenuItem($menuItem);
    }
}
