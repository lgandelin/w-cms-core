<?php

class MenuTest extends PHPUnit_Framework_TestCase {

    public function testConstruct()
    {
        $menu = new \CMS\Entities\Menu();

        $this->assertInstanceOf('\CMS\Entities\Menu', $menu);
    }

    public function testGetIdentifier()
    {
        $menu = new \CMS\Entities\Menu();
        $menu->setIdentifier('main-menu');

        $this->assertEquals('main-menu', $menu->getIdentifier());
    }

    public function testGetName()
    {
        $menu = new \CMS\Entities\Menu();
        $menu->setName('My Menu');

        $this->assertEquals('My Menu', $menu->getName());
    }

    public function testGetItems()
    {
        $menu = new \CMS\Entities\Menu();
        $this->assertEquals([], $menu->getItems());

        $item = new \CMS\Entities\MenuItem();
        $menu->addItem($item);
        $this->assertEquals([$item], $menu->getItems());
    }

}
 