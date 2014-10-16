<?php

use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
use CMS\Interactors\MenuItems\UpdateMenuItemInteractor;
use CMS\Repositories\InMemory\InMemoryMenuItemRepository;
use CMS\Repositories\InMemory\InMemoryMenuRepository;
use CMS\Structures\MenuItemStructure;
use CMS\Structures\MenuStructure;

class UpdateMenuItemInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;

    public function setUp()
    {
        $this->repository = new InMemoryMenuItemRepository();
        $this->menuRepository = new InMemoryMenuRepository();
        $this->interactor = new UpdateMenuItemInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingItem()
    {
        $menuItemStructure = new MenuItemStructure([
            'label' => 'Menu Item',
            'page' => null,
        ]);

        $this->interactor->run(1, $menuItemStructure);
    }

    public function testUpdateItem()
    {
        $this->createSampleMenu();
        $this->createSampleMenuItem();
        $this->assertCount(1, $this->repository->findByMenuID(1));

        $menuItemStructureUpdated = new MenuItemStructure([
            'label' => 'Test menu item updated',
        ]);

        $this->interactor->run(1,$menuItemStructureUpdated);

        $menuItem = $this->repository->findByID(1);

        $this->assertEquals('Test menu item updated', $menuItem->getLabel());
    }

    private function createSampleMenu()
    {
        $menu = new Menu();
        $menu->setID(1);
        $menu->setName('Test menu');
        $menu->setIdentifier('test-menu');

        $this->menuRepository->createMenu($menu);

        return $menu;
    }

    private function createSampleMenuItem()
    {
        $menuItem = new MenuItem();
        $menuItem->setID(1);
        $menuItem->setMenuID(1);
        $menuItem->setLabel('Test menu item');
        $menuItem->setOrder(1);

        $this->repository->createMenuItem($menuItem);
    }
}