<?php

use CMS\Context;
use CMS\Entities\Menu;
use CMS\Interactors\Menus\GetMenuInteractor;

class GetMenuInteractorTest extends PHPUnit_Framework_TestCase
{
    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetMenuInteractor();
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

        Context::get('menu')->createMenu($menu);

        return $menu;
    }
}
