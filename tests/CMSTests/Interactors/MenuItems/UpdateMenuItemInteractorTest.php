<?php

use CMS\Context;
use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
use CMS\Interactors\MenuItems\UpdateMenuItemInteractor;
use CMS\DataStructure;

class UpdateMenuItemInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp()
    {
        CMSTestsSuite::clean();
        $this->interactor = new UpdateMenuItemInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingItem()
    {
        $menuItemStructure = new DataStructure([
            'label' => 'Menu Item',
            'page' => null,
        ]);

        $this->interactor->run(1, $menuItemStructure);
    }

    public function testUpdateItem()
    {
        $this->createSampleMenu();
        $this->createSampleMenuItem();
        $this->assertCount(1, Context::getRepository('menu_item')->findByMenuID(1));

        $menuItemStructureUpdated = new DataStructure([
            'label' => 'Test menu item updated',
        ]);

        $this->interactor->run(1, $menuItemStructureUpdated);

        $menuItem = Context::getRepository('menu_item')->findByID(1);

        $this->assertEquals('Test menu item updated', $menuItem->getLabel());
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
        $menuItem->setOrder(1);

        Context::getRepository('menu_item')->createMenuItem($menuItem);
    }
}
