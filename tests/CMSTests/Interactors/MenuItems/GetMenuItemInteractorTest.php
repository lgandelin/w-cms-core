<?php

use CMS\Context;
use CMS\Entities\MenuItem;
use CMS\Interactors\MenuItems\GetMenuItemInteractor;

class GetMenuItemItemInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetMenuItemInteractor(Context::getRepository('menu_item'));
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

        Context::getRepository('menu_item')->createMenuItem($menu);

        return $menu;
    }
}
