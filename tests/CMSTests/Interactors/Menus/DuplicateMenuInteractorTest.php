<?php

use CMS\Context;
use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
use CMS\Interactors\Menus\DuplicateMenuInteractor;

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
        $this->assertCount(1, Context::$menuRepository->findAll());

        $this->interactor->run(1);

        $this->assertCount(2, Context::$menuRepository->findAll());
        $menuDuplicated = Context::$menuRepository->findByIdentifier('test-menu-copy');
        $this->assertInstanceOf('\CMS\Entities\Menu', $menuDuplicated);

        $this->assertEquals($menuDuplicated->getName(), 'Test menu - COPY');
        $this->assertEquals($menuDuplicated->getIdentifier(), 'test-menu-copy');
    }

    public function testDuplicateMenuAlongWithMenuItems()
    {
        $this->createSampleMenu();
        $this->createSampleMenuItem(1);
        $this->createSampleMenuItem(2);
        $this->createSampleMenuItem(3);
        $this->assertCount(1, Context::$menuRepository->findAll());
        $this->assertCount(3, Context::$menuItemRepository->findByMenuID(1));

        $this->interactor->run(1);

        $this->assertCount(2, Context::$menuRepository->findAll());
        $menuDuplicated = Context::$menuRepository->findByIdentifier('test-menu-copy');
        $this->assertCount(3, Context::$menuItemRepository->findByMenuID($menuDuplicated->getID()));
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
        $menuItem->setOrder(999);

        Context::$menuItemRepository->createMenuItem($menuItem);
    }
}
