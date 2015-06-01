<?php

use CMS\Context;
use CMS\Entities\Menu;
use CMS\Interactors\MenuItems\CreateMenuItemInteractor;
use CMS\Structures\MenuItemStructure;

class CreateMenuItemTestInteractor extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateMenuItemInteractor();
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

        $this->assertCount(3, Context::$menuItemRepository->findByMenuID(1));
    }

    private function createSampleMenu()
    {
        $menu = new Menu();
        $menu->setID(1);
        $menu->setName('Test menu');
        $menu->setIdentifier('test-menu');

        Context::$menuRepository->createMenu($menu);

        return $menu;
    }
}
