<?php

use CMS\Entities\Menu;
use CMS\Interactors\Menus\GetMenusInteractor;
use CMSTests\Repositories\InMemoryMenuRepository;
use CMS\Structures\MenuStructure;

class GetAllMenusInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;
    private $repository;

    public function setUp()
    {
        $this->repository = new InMemoryMenuRepository();
        $this->interactor = new GetMenusInteractor($this->repository);
    }

    public function testGetAllWithoutMenus()
    {
        $this->assertCount(0, $this->interactor->getAll());
    }

    public function testGetAll()
    {
        $this->createSampleMenu(1);
        $this->createSampleMenu(2);

        $menus = $this->interactor->getAll();
        $this->assertCount(2, $menus);
        $this->assertInstanceOf('\CMS\Entities\Menu', $menus[0]);
    }

    public function testGetAllByStructures()
    {
        $this->createSampleMenu(1);
        $this->createSampleMenu(1);

        $menus = $this->interactor->getAll(true);
        $this->assertCount(2, $menus);
        $this->assertInstanceOf('\CMS\Structures\MenuStructure', $menus[0]);
    }

    private function createSampleMenu($menuID)
    {
        $menu = new Menu();
        $menu->setID($menuID);
        $menu->setName('Test menu');
        $menu->setIdentifier('test-menu');

        $this->repository->createMenu($menu);

        return $menu;
    }
}
