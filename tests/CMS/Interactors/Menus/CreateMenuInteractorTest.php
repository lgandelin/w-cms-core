<?php

use CMS\Interactors\Menus\CreateMenuInteractor;
use CMS\Repositories\InMemory\InMemoryMenuRepository;
use CMS\Structures\MenuStructure;

class CreateMenuInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryMenuRepository();
        $this->interactor = new CreateMenuInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateMenuWithoutIdentifier()
    {
        $menuStructure = new MenuStructure([
            'name' => 'Menu'
        ]);

        $this->interactor->run($menuStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateMenuWithAnotherExistingMenuWithSameIdentifier()
    {
        $menuStructure = new MenuStructure([
            'name' => 'Menu 1',
            'identifier' => 'my-menu',
        ]);

        $this->interactor->run($menuStructure);

        $menuStructure = new MenuStructure([
            'name' => 'Menu 2',
            'identifier' => 'my-menu',
        ]);

        $this->interactor->run($menuStructure);
    }

    public function testCreateMenu()
    {
        $this->assertCount(0, $this->repository->findAll());

        $menuStructure = new MenuStructure([
            'name' => 'Main menu',
            'identifier' => 'main-menu'
        ]);

        $this->interactor->run($menuStructure);

        $this->assertCount(1, $this->repository->findAll());
    }
}
