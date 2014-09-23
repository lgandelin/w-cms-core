<?php

use CMS\Converters\MenuConverter;
use CMS\Interactors\Menus\UpdateMenuInteractor;
use CMS\Repositories\InMemory\InMemoryMenuRepository;
use CMS\Structures\MenuStructure;

class UpdateMenuInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->repository = new InMemoryMenuRepository();
        $this->interactor = new UpdateMenuInteractor($this->repository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Menus\UpdateMenuInteractor', $this->interactor);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingMenu()
    {
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Menu',
            'identifier' => 'my-menu'
        ]);

        $this->interactor->run(1, $menuStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateMenuWithInvalidIdentifier()
    {
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Menu',
            'identifier' => 'main-menu'
        ]);

        $this->repository->createMenu($menuStructure);

        $menuStructureUpdated = new MenuStructure([
            'identifier' => ''
        ]);
        $this->interactor->run(1, $menuStructureUpdated);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateMenuWithAlreadyExistingMenuWithSameIdentifier()
    {
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Menu 1',
            'identifier' => 'my-menu'
        ]);

        $this->repository->createMenu($menuStructure);

        $menuStructure2 = new MenuStructure([
            'ID' => 2,
            'name' => 'Menu 2',
            'identifier' => 'my-menu-2'
        ]);

        $this->repository->createMenu($menuStructure2);

        $menuStructure2Updated = new MenuStructure([
            'identifier' => 'my-menu'
        ]);

        $this->interactor->run(2, $menuStructure2Updated);
    }

    public function testUpdateMenu()
    {
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Main menu',
            'identifier' => 'main-menu'
        ]);

        $this->repository->createMenu($menuStructure);

        $menuStructureUpdated = new MenuStructure([
            'name' => 'Main menu updated',
            'identifier' => 'main-menu'
        ]);

        $this->interactor->run(1, $menuStructureUpdated);

        $menuStructure = $this->repository->findByID(1);
        $menu = MenuConverter::convertMenuStructureToMenu($menuStructure);

        $this->assertEquals('Main menu updated', $menu->getName());
        $this->assertEquals('main-menu', $menu->getIdentifier());
    }
}
 