<?php

use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
use CMS\Interactors\MenuItems\DeleteMenuItemInteractor;
use CMS\Repositories\InMemory\InMemoryMenuItemRepository;
use CMS\Repositories\InMemory\InMemoryMenuRepository;

class DeleteMenuItemInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;

    public function setUp()
    {
        $this->repository = new InMemoryMenuItemRepository();
        $this->menuRepository = new InMemoryMenuRepository();
        $this->interactor = new DeleteMenuItemInteractor($this->repository);
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

        $this->assertEquals(1, count($this->repository->findByMenuID(1)));

        //Delete the item
        $this->interactor->run(1);

        $this->assertEquals(0, count($this->repository->findByMenuID(1)));
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

        $this->repository->createMenuItem($menuItem);
    }

}
 