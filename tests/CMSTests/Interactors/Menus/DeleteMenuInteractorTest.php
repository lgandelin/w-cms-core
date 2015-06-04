<?php

use CMS\Context;
use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
use CMS\Interactors\Menus\DeleteMenuInteractor;

class DeleteMenuInteractorTest extends PHPUnit_Framework_TestCase
{
    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new DeleteMenuInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingMenu()
    {
        $this->interactor->run(2);
    }

    public function testDelete()
    {
        $this->createSampleMenu();

        $this->assertCount(1, Context::$menuRepository->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, Context::$menuRepository->findAll());
    }

    public function testDeleteAlongWithMenuItems()
    {
        $this->createSampleMenu();
        $this->createSampleMenuItem(1);
        $this->createSampleMenuItem(2);

        $this->assertCount(1, Context::$menuRepository->findAll());
        $this->assertCount(2, Context::$menuItemRepository->findByMenuID(1));

        $this->interactor->run(1);

        $this->assertCount(0, Context::$menuRepository->findAll());
        $this->assertCount(0, Context::$menuItemRepository->findByMenuID(1));
    }

    private function createSampleMenu()
    {
        $menu = new Menu();
        $menu->setID(1);
        $menu->setName('Test menu');
        $menu->setIdentifier('test-menu');

        Context::$menuRepository->createMenu($menu);

        return $menu;
    }

    private function createSampleMenuItem($menuItemID)
    {
        $menuItem = new MenuItem();
        $menuItem->setID($menuItemID);
        $menuItem->setMenuID(1);
        $menuItem->setLabel('Test menu item');

        Context::$menuItemRepository->createMenuItem($menuItem);
    }
}
