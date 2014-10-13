<?php

use CMS\Entities\Menu;
use CMS\Interactors\MenuItems\CreateMenuItemInteractor;
use CMS\Interactors\MenuItems\GetMenuItemsInteractor;
use CMS\Interactors\Menus\CreateMenuInteractor;
use CMS\Interactors\Menus\DuplicateMenuInteractor;
use CMS\Repositories\InMemory\InMemoryMenuItemRepository;
use CMS\Repositories\InMemory\InMemoryMenuRepository;

class DuplicateMenuInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;
    private $menuRepository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryMenuRepository();
        $this->menuRepository = new InMemoryMenuItemRepository();
        $this->interactor = new DuplicateMenuInteractor($this->repository, new CreateMenuInteractor($this->repository), new GetMenuItemsInteractor($this->menuRepository), new CreateMenuItemInteractor($this->menuRepository));
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
        $this->assertCount(1, $this->repository->findAll());

        $this->interactor->run(1);

        $this->assertCount(2, $this->repository->findAll());
        $menuDuplicated = $this->repository->findByIdentifier('test-menu-copy');
        $this->assertInstanceOf('\CMS\Entities\Menu', $menuDuplicated);

        $this->assertEquals($menuDuplicated->getName(), 'Test menu - COPY');
        $this->assertEquals($menuDuplicated->getIdentifier(), 'test-menu-copy');
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

}
 