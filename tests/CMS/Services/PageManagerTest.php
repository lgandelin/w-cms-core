<?php

class PageManagerTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->pageManager = new \CMS\Services\PageManager(new PageMapperMock());
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Services\PageManager', $this->pageManager);
    }

    public function testGetBySlug()
    {
        $this->assertEquals($this->pageManager->getBySlug('/my-page')->getName(), 'My Page');
    }
}

class PageMapperMock implements \CMS\Mappers\PageMapperInterface {

    public function findBySlug($slug)
    {
        $page = new \CMS\Entities\Page();
        $page->setName('My Page');
        $page->setSlug('/my-page');

        return $page;
    }
}