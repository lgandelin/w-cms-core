<?php

use CMS\Entities\Menu;
use CMS\Interactors\Menus\GetMenuInteractor;
use CMS\Repositories\InMemory\InMemoryMenuRepository;
use CMS\Structures\MenuStructure;

class GetMenuInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryMenuRepository();
        $this->interactor = new GetMenuInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingMenu()
    {
        $this->interactor->getMenuByID(1);
    }

    public function testGetMenu()
    {
        $menu = $this->createSampleMenu();

        $this->assertEquals($menu, $this->interactor->getMenuByID(1));
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
