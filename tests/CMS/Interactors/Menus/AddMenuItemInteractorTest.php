<?php

use CMS\Converters\MenuConverter;
use CMS\Converters\MenuItemConverter;
use CMS\Interactors\Menus\AddMenuItemInteractor;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Repositories\InMemory\InMemoryMenuRepository;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\MenuItemStructure;
use CMS\Structures\MenuStructure;
use CMS\Structures\PageStructure;

class AddMenuItemTestInteractor extends PHPUnit_Framework_TestCase {

    private $repository;
    private $pageRepository;

    public function setUp()
    {
        $this->repository = new InMemoryMenuRepository();
        $this->pageRepository = new InMemoryPageRepository();
        $this->interactor = new AddMenuItemInteractor($this->repository, $this->pageRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Menus\AddMenuItemInteractor', $this->interactor);
    }

    /**
     * @expectedException Exception
     */
    public function testAddMenuItemToNonExistingMenu()
    {
        $menuItemStructure = new MenuItemStructure([
            'label' => 'Menu Item',
            'page' => null,
            'order' => 1
        ]);

        $this->interactor->run(1, $menuItemStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testAddMenuItemWithInvalidOrder()
    {
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Main menu',
            'identifier' => 'main-menu'
        ]);

        $this->repository->createMenu($menuStructure);

        $menuItemStructure = new MenuItemStructure([
            'label' => 'Menu Item',
            'page' => null,
            'order' => 'x'
        ]);

        $this->interactor->run(1, $menuItemStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testAddMenuItemWithInvalidLabel()
    {
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Main menu',
            'identifier' => 'main-menu'
        ]);

        $this->repository->createMenu($menuStructure);

        $menuItemStructure = new MenuItemStructure([
            'label' => '',
            'page_id' => null,
            'order' => 1
        ]);

        $this->interactor->run(1, $menuItemStructure);
    }

    public function testAddMenuItem()
    {
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Main menu',
            'identifier' => 'main-menu'
        ]);

        $this->repository->createMenu($menuStructure);
        $this->assertCount(1, $this->repository->findAll());

        $menuItemStructure = new MenuItemStructure([
            'label' => 'Menu Item',
            'page_id' => null,
            'order' => 1
        ]);

        $this->interactor->run(1, $menuItemStructure);

        $menuStructure = $this->repository->findByID(1);
        $menu = MenuConverter::convertMenuStructureToMenu($menuStructure);

        $this->assertCount(1, $menu->getItems());
    }

    public function testAddSeveralMenuItems()
    {
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Main menu',
            'identifier' => 'main-menu'
        ]);

        $this->repository->createMenu($menuStructure);
        $this->assertCount(1, $this->repository->findAll());

        for ($i = 1; $i <=3; $i++) {
            $menuItemStructure = new MenuItemStructure([
                'ID' => $i,
                'label' => 'Menu Item' . $i,
                'page_id' => null,
                'order' => $i
            ]);

            $this->interactor->run(1, $menuItemStructure);
        }

        $menuStructure = $this->repository->findByID(1);
        $menu = MenuConverter::convertMenuStructureToMenu($menuStructure);

        $this->assertCount(3, $menu->getItems());
    }

    /**
     * @expectedException Exception
     */
    public function testAddMenuItemWithNonExistingPage()
    {
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Main menu',
            'identifier' => 'main-menu'
        ]);
        $this->repository->createMenu($menuStructure);

        $menuItemStructure = new MenuItemStructure([
            'ID' => 1,
            'label' => 'Menu Item 1',
            'page_id' => 1,
            'order' => 1
        ]);
        $this->interactor->run(1, $menuItemStructure);
    }

}
 