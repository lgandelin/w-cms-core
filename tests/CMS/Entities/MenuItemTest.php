<?php

class MenuItemTest extends PHPUnit_Framework_TestCase {

    public function testConstruct()
    {
        $item = new \CMS\Entities\MenuItem();

        $this->assertInstanceOf('\CMS\Entities\MenuItem', $item);
    }

    public function testGetLabel()
    {
        $item = new \CMS\Entities\MenuItem();
        $item->setLabel('Home page');

        $this->assertEquals('Home page', $item->getLabel());
    }

    public function testGetPage()
    {
        $item = new \CMS\Entities\MenuItem();
        $page = new \CMS\Entities\Page();
        $item->setPage($page);

        $this->assertEquals($page, $item->getPage());
    }

    public function testGetOrder()
    {
        $item = new \CMS\Entities\MenuItem();
        $item->setOrder(2);

        $this->assertEquals(2, $item->getOrder());
    }

}
 