<?php

use CMS\Interactors\Menus\GetMenuInteractor;
use CMS\Repositories\InMemory\InMemoryMenuRepository;
use CMS\Structures\MenuStructure;

class GetMenuInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->repository = new InMemoryMenuRepository();
        $this->interactor = new GetMenuInteractor($this->repository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Menus\GetMenuInteractor', $this->interactor);
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingMenu()
    {
        $this->interactor->getByID(1);
    }

    public function testGetMenu()
    {
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Menu',
            'identifier' => 'menu'
        ]);

        $this->repository->createMenu($menuStructure);

        $this->assertEquals($menuStructure, $this->interactor->getByID(1));
    }
}
 