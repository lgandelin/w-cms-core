<?php

use CMS\Context;
use CMS\Entities\Menu;
use CMS\Interactors\MenuItems\CreateMenuItemInteractor;
use CMS\DataStructure;

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
        $menuItemStructure = new DataStructure([
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

        $menuItemStructure = new DataStructure([
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

        $menuItemStructure = new DataStructure([
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
            $menuItemStructure = new DataStructure([
                'ID' => $i,
                'label' => 'Menu item ' . $i,
                'order' => $i,
                'menu_id' => 1
            ]);

            $this->interactor->run($menuItemStructure);
        }

        $this->assertCount(3, Context::getRepository('menu_item')->findByMenuID(1));
    }

    private function createSampleMenu()
    {
        $menu = new Menu();
        $menu->setID(1);
        $menu->setName('Test menu');
        $menu->setIdentifier('test-menu');

        Context::getRepository('menu')->createMenu($menu);

        return $menu;
    }
}
