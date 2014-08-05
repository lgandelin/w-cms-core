<?php

use CMS\Converters\MenuItemConverter;
use CMS\Interactors\Menus\UpdateMenuItemInteractor;
use CMS\Repositories\InMemory\InMemoryMenuRepository;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\MenuItemStructure;
use CMS\Structures\MenuStructure;

class UpdateMenuItemInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;

    public function setUp()
    {
        $this->repository = new InMemoryMenuRepository();
        $this->pageRepository = new InMemoryPageRepository();
        $this->interactor = new UpdateMenuItemInteractor($this->repository, $this->pageRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Menus\UpdateMenuItemInteractor', $this->interactor);
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
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Main menu',
            'identifier' => 'main-menu'
        ]);

        $this->repository->createMenu($menuStructure);
        $this->assertCount(1, $this->repository->findAll());

        $menuItemStructure = new MenuItemStructure([
            'ID' => 1,
            'label' => 'Menu Item',
            'page_id' => 1,
            'order' => 1
        ]);

        $this->repository->addItem(1, $menuItemStructure);

        $menuItemStructureUpdated = new MenuItemStructure([
            'label' => 'New Menu Item',
        ]);

        $this->interactor->run(1, 1, $menuItemStructureUpdated);

        $menuItemStructure = $this->repository->findItemByID(1, 1);
        $menuItem = MenuItemConverter::convertMenuItemStructureToMenuItem($menuItemStructure);

        $this->assertEquals('New Menu Item', $menuItem->getLabel());
    }

}