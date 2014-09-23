<?php

use CMS\Interactors\Menus\GetAllMenusInteractor;
use CMS\Repositories\InMemory\InMemoryMenuRepository;
use CMS\Structures\MenuStructure;

class GetAllMenusInteractorTest extends PHPUnit_Framework_TestCase {

    private $interactor;
    private $repository;

    public function setUp()
    {
        $this->repository = new InMemoryMenuRepository();
        $this->interactor = new GetAllMenusInteractor($this->repository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Menus\GetAllMenusInteractor', $this->interactor);
    }

    public function testGetAllWithoutMenus()
    {
        $this->assertCount(0, $this->interactor->getAll());
    }

    public function testGetAll()
    {
        $menuStructure = new MenuStructure([
            'name' => 'Menu 1',
            'identifier' => 'menu-1',
        ]);

        $menuStructure2 = new MenuStructure([
            'name' => 'Menu 2',
            'identifier' => 'menu-2',
        ]);

        $this->repository->createMenu($menuStructure);
        $this->repository->createMenu($menuStructure2);


        $this->assertCount(2, $this->interactor->getAll());
    }
}
 