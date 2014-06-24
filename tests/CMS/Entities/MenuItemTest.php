<?php

use CMS\Entities\MenuItem;
use CMS\Entities\Page;

class MenuItemTest extends PHPUnit_Framework_TestCase {

    public function testConstruct()
    {
        $item = new MenuItem();

        $this->assertInstanceOf('CMS\Entities\MenuItem', $item);
    }

    public function testGetLabel()
    {
        $item = new MenuItem();
        $item->setLabel('Home page');

        $this->assertEquals('Home page', $item->getLabel());
    }

    public function testGetPage()
    {
        $item = new MenuItem();
        $page = new Page();
        $item->setPage($page);

        $this->assertEquals($page, $item->getPage());
    }

    public function testGetOrder()
    {
        $item = new MenuItem();
        $item->setOrder(2);

        $this->assertEquals(2, $item->getOrder());
    }

}
 