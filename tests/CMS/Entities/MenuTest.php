<?php

use CMS\Entities\Menu;
use CMS\Entities\MenuItem;

class MenuTest extends PHPUnit_Framework_TestCase {

    public function testConstruct()
    {
        $menu = new Menu();

        $this->assertInstanceOf('CMS\Entities\Menu', $menu);
    }

    public function testGetIdentifier()
    {
        $menu = new Menu();
        $menu->setIdentifier('main-menu');

        $this->assertEquals('main-menu', $menu->getIdentifier());
    }

    public function testGetName()
    {
        $menu = new Menu();
        $menu->setName('My Menu');

        $this->assertEquals('My Menu', $menu->getName());
    }

    public function testGetItems()
    {
        $menu = new Menu();
        $this->assertEquals([], $menu->getItems());

        $item = new MenuItem();
        $menu->addItem($item);
        $this->assertEquals([$item], $menu->getItems());
    }

}
 