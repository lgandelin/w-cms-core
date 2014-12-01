<?php

use CMS\Entities\Menu;
use CMS\Interactors\MenuItems\CreateMenuItemInteractor;
use CMS\Repositories\InMemory\InMemoryMenuItemRepository;
use CMS\Repositories\InMemory\InMemoryMenuRepository;
use CMS\Structures\MenuItemStructure;

class CreateMenuItemTestInteractor extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $menuRepository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryMenuItemRepository();
        $this->menuRepository = new InMemoryMenuRepository();
        $this->interactor = new CreateMenuItemInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateMenuItemToNonExistingMenu()
    {
        $menuItemStructure = new MenuItemStructure([
            'label' => 'Menu Item',
            'page' => null,
            'order' => 1
        ]);

        $this->interactor->run(1, $menuItemStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateMenuItemWithInvalidOrder()
    {
        $this->createSampleMenu();

        $menuItemStructure = new MenuItemStructure([
            'label' => 'Menu Item',
            'page' => null,
            'order' => 'x'
        ]);

        $this->interactor->run(1, $menuItemStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateMenuItemWithInvalidLabel()
    {
        $this->createSampleMenu();

        $menuItemStructure = new MenuItemStructure([
            'label' => '',
            'page_id' => null,
            'order' => 1
        ]);

        $this->interactor->run(1, $menuItemStructure);
    }

    public function testCreateMenuItems()
    {
        $this->createSampleMenu();

        for ($i = 1; $i <= 3; $i++) {
            $menuItemStructure = new MenuItemStructure([
                'ID' => $i,
                'label' => 'Menu item ' . $i,
                'order' => $i,
                'menu_id' => 1
            ]);

            $this->interactor->run($menuItemStructure);
        }

        $this->assertCount(3, $this->repository->findByMenuID(1));
    }

    private function createSampleMenu()
    {
        $menu = new Menu();
        $menu->setID(1);
        $menu->setName('Test menu');
        $menu->setIdentifier('test-menu');

        $this->menuRepository->createMenu($menu);

        return $menu;
    }
}
