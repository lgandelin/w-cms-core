<?php

use CMS\Interactors\Menus\DuplicateMenuInteractor;
use CMS\Repositories\InMemory\InMemoryMenuRepository;
use CMS\Structures\MenuStructure;

class DuplicateMenuInteractorTest extends PHPUnit_Framework_TestCase {

    private $interactor;
    private $repository;

    public function setUp()
    {
        $this->repository = new InMemoryMenuRepository();
        $this->interactor = new DuplicateMenuInteractor($this->repository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Menus\DuplicateMenuInteractor', $this->interactor);
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
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'My menu',
            'identifier' => 'my-menu'
        ]);

        $this->repository->createMenu($menuStructure);
        $this->assertCount(1, $this->repository->findAll());

        $this->interactor->run(1);

        $this->assertCount(2, $this->repository->findAll());
        $menuStructureDuplicated = $this->repository->findByIdentifier('my-menu-copy');
        $this->assertInstanceOf('\CMS\Structures\MenuStructure', $menuStructureDuplicated);

        $this->assertEquals($menuStructureDuplicated->name, 'My menu - COPY');
        $this->assertEquals($menuStructureDuplicated->identifier, 'my-menu-copy');
    }

}
 