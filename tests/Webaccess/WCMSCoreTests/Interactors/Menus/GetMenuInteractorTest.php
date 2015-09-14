<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Menu;
use Webaccess\WCMSCore\Interactors\Menus\GetMenuInteractor;

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

        Context::get('menu_repository')->createMenu($menu);

        return $menu;
    }
}
