<?php

use CMS\Entities\MenuItem;
use CMS\Interactors\MenuItems\GetMenuItemsInteractor;
use CMSTests\Repositories\InMemoryMenuItemRepository;

class GetMenuItemsInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;
    private $repository;

    public function setUp()
    {
        $this->repository = new InMemoryMenuItemRepository();
        $this->interactor = new GetMenuItemsInteractor($this->repository);
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
        $this->assertInstanceOf('\CMS\Entities\MenuItem', $menus[0]);
    }

    public function testGetAllByStructures()
    {
        $this->createSampleMenuItem(1);
        $this->createSampleMenuItem(2);

        $menus = $this->interactor->getAll(1, true);
        $this->assertCount(2, $menus);
        $this->assertInstanceOf('\CMS\Structures\MenuItemStructure', $menus[0]);
    }

    private function createSampleMenu()
    {
        $menu = new Menu();
        $menu->setID(1);
        $menu->setName('Test menu');
        $menu->setIdentifier('test-menu');

        $this->repository->createMenu($menu);

        return $menu;
    }

    private function createSampleMenuItem($menuItemID)
    {
        $menu = new MenuItem();
        $menu->setID($menuItemID);
        $menu->setMenuID(1);
        $menu->setLabel('Test menu item');
        $menu->setOrder(999);

        $this->repository->createMenuItem($menu);

        return $menu;
    }
}
