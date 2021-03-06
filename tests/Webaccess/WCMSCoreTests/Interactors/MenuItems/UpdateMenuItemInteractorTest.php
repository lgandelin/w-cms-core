<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Menu;
use Webaccess\WCMSCore\Entities\MenuItem;
use Webaccess\WCMSCore\Interactors\MenuItems\UpdateMenuItemInteractor;
use Webaccess\WCMSCore\DataStructure;

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
        $this->assertCount(1, Context::get('menu_item_repository')->findByMenuID(1));

        $menuItemStructureUpdated = new DataStructure([
            'label' => 'Test menu item updated',
        ]);

        $this->interactor->run(1, $menuItemStructureUpdated);

        $menuItem = Context::get('menu_item_repository')->findByID(1);

        $this->assertEquals('Test menu item updated', $menuItem->getLabel());
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
        $menuItem->setOrder(1);

        Context::get('menu_item_repository')->createMenuItem($menuItem);
    }
}
