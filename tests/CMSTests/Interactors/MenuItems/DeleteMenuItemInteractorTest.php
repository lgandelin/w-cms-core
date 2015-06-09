<?php

use CMS\Context;
use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
use CMS\Interactors\MenuItems\DeleteMenuItemInteractor;

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

        $this->assertEquals(1, count(Context::getRepository('menu_item')->findByMenuID(1)));

        //Delete the item
        $this->interactor->run(1);

        $this->assertEquals(0, count(Context::getRepository('menu_item')->findByMenuID(1)));
    }

    private function createSampleMenu()
    {
        $menu = new Menu();
        $menu->setID(1);
        $menu->setName('Test menu');
        $menu->setIdentifier('test-menu');

        Context::getRepository('menu')->createMenu($menu);

        return $menu;
    }

    private function createSampleMenuItem()
    {
        $menuItem = new MenuItem();
        $menuItem->setID(1);
        $menuItem->setMenuID(1);
        $menuItem->setLabel('Test menu item');

        Context::getRepository('menu_item')->createMenuItem($menuItem);
    }
}
