<?php

use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
use CMS\Interactors\MenuItems\DeleteMenuItemInteractor;
use CMS\Interactors\MenuItems\GetMenuItemsInteractor;
use CMS\Interactors\Menus\DeleteMenuInteractor;
use CMSTests\Repositories\InMemoryMenuItemRepository;
use CMSTests\Repositories\InMemoryMenuRepository;

class DeleteMenuInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $menuItemRepository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryMenuRepository();
        $this->menuItemRepository = new InMemoryMenuItemRepository();
        $this->interactor = new DeleteMenuInteractor($this->repository, new GetMenuItemsInteractor($this->menuItemRepository), new DeleteMenuItemInteractor($this->menuItemRepository));
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

        $this->assertCount(1, $this->repository->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, $this->repository->findAll());
    }

    public function testDeleteAlongWithMenuItems()
    {
        $this->createSampleMenu();
        $this->createSampleMenuItem(1);
        $this->createSampleMenuItem(2);

        $this->assertCount(1, $this->repository->findAll());
        $this->assertCount(2, $this->menuItemRepository->findByMenuID(1));

        $this->interactor->run(1);

        $this->assertCount(0, $this->repository->findAll());
        $this->assertCount(0, $this->menuItemRepository->findByMenuID(1));
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
        $menuItem = new MenuItem();
        $menuItem->setID($menuItemID);
        $menuItem->setMenuID(1);
        $menuItem->setLabel('Test menu item');

        $this->menuItemRepository->createMenuItem($menuItem);
    }
}
