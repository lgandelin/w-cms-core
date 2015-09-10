<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Menu;
use Webaccess\WCMSCore\Interactors\Menus\UpdateMenuInteractor;
use Webaccess\WCMSCore\DataStructure;

class UpdateMenuInteractorTest extends PHPUnit_Framework_TestCase
{
    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new UpdateMenuInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingMenu()
    {
        $menuStructure = new DataStructure([
            'ID' => 1,
            'name' => 'Menu',
            'identifier' => 'my-menu'
        ]);

        $this->interactor->run(1, $menuStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateMenuWithInvalidIdentifier()
    {
        $this->createSampleMenu(1);

        $menuStructureUpdated = new DataStructure([
            'identifier' => ''
        ]);
        $this->interactor->run(1, $menuStructureUpdated);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateMenuWithAlreadyExistingMenuWithSameIdentifier()
    {
        $this->createSampleMenu(1);
        $this->createSampleMenu(2);

        $menuStructure2Updated = new DataStructure([
            'identifier' => 'test-menu-1'
        ]);

        $this->interactor->run(2, $menuStructure2Updated);
    }

    public function testUpdateMenu()
    {
        $this->createSampleMenu(1);

        $menuStructureUpdated = new DataStructure([
            'name' => 'Main menu updated',
            'identifier' => 'main-menu'
        ]);

        $this->interactor->run(1, $menuStructureUpdated);

        $menu = Context::get('menu_repository')->findByID(1);

        $this->assertEquals('Main menu updated', $menu->getName());
        $this->assertEquals('main-menu', $menu->getIdentifier());
    }

    private function createSampleMenu($menuID)
    {
        $menu = new Menu();
        $menu->setID($menuID);
        $menu->setName('Test menu ' . $menuID);
        $menu->setIdentifier('test-menu-' . $menuID);

        Context::get('menu_repository')->createMenu($menu);

        return $menu;
    }
}
