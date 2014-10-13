<?php

use CMS\Entities\Menu;
use CMS\Interactors\Menus\DeleteMenuInteractor;
use CMS\Repositories\InMemory\InMemoryMenuRepository;
use CMS\Structures\MenuStructure;

class DeleteMenuInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryMenuRepository();
        $this->interactor = new DeleteMenuInteractor($this->repository);
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
 