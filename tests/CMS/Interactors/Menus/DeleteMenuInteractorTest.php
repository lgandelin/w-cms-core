<?php

use CMS\Interactors\Menus\DeleteMenuInteractor;
use CMS\Repositories\InMemory\InMemoryMenuRepository;
use CMS\Structures\MenuStructure;

class DeleteMenuInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->repository = new InMemoryMenuRepository();
        $this->interactor = new DeleteMenuInteractor($this->repository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Menus\DeleteMenuInteractor', $this->interactor);
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingMenu()
    {
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Main menu',
            'identifier' => 'main-menu'
        ]);

        $this->repository->createMenu($menuStructure);
        $this->assertCount(1, $this->repository->findAll());

        $this->interactor->run(2);
    }

    public function testDelete()
    {
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Main menu',
            'identifier' => 'main-menu'
        ]);

        $this->repository->createMenu($menuStructure);

        $this->assertCount(1, $this->repository->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, $this->repository->findAll());
    }
}
 