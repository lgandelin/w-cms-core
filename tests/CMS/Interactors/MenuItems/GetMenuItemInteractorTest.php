<?php

use CMS\Entities\MenuItem;
use CMS\Interactors\MenuItems\GetMenuItemInteractor;
use CMS\Repositories\InMemory\InMemoryMenuItemRepository;

class GetMenuItemItemInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryMenuItemRepository();
        $this->interactor = new GetMenuItemInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingMenuItem()
    {
        $this->interactor->getMenuItemByID(1);
    }

    public function testGetMenuItem()
    {
        $menu = $this->createSampleMenuItem();

        $this->assertEquals($menu, $this->interactor->getMenuItemByID(1));
    }

    private function createSampleMenuItem()
    {
        $menu = new MenuItem();
        $menu->setID(1);
        $menu->setMenuID(1);
        $menu->setLabel('Test menu item');

        $this->repository->createMenuItem($menu);

        return $menu;
    }
}
