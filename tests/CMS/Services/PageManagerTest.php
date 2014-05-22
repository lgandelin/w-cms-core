<?php

class PageManagerTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->pageMapper = Phake::mock('\CMS\Mappers\PageMapperInterface');
    }

    public function getPageManager()
    {
        return new \CMS\Services\PageManager($this->pageMapper);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Services\PageManager', $this->getPageManager());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateInvalidPageObject()
    {
        \CMS\Services\PageManager::createPageObject('Page 1', '');
    }

    public function testCreatePageObject()
    {
        $page = \CMS\Services\PageManager::createPageObject('My Page', '/my-page', '', '<p>This is a test</p>');

        $this->assertInstanceOf('\CMS\Entities\Page', $page);
        $this->assertEquals('My Page', $page->getName());
        $this->assertEquals('/my-page', $page->getUri());
        $this->assertEquals('my-page', $page->getIdentifier());
        $this->assertEquals('<p>This is a test</p>', $page->getText());
    }

    public function testDuplicatePageObject()
    {
        $page = \CMS\Services\PageManager::createPageObject('My Page', '/my-page', 'my-page', '<p>This is some random text</p>');
        $pageCopyExpected = \CMS\Services\PageManager::createPageObject('My Page COPY', '/my-page-copy', 'my-page-copy', '<p>This is some random text</p>');

        $this->assertEquals($pageCopyExpected, \CMS\Services\PageManager::duplicatePageObject($page));
    }

    public function testGetByIdentifierNonExisting()
    {
        Phake::when($this->pageMapper)->findByIdentifier('my-page')->thenReturn(null);

        $this->assertEquals(null, $this->getPageManager()->getByIdentifier('my-page'));
    }

    public function testGetByIdentifier()
    {
        $page = \CMS\Services\PageManager::createPageObject('My Page', '/my-page', 'my-page');
        Phake::when($this->pageMapper)->findByIdentifier('my-page')->thenReturn($page);

        $this->assertEquals($page, $this->getPageManager()->getByIdentifier('my-page'));
    }

    public function testGetByUriNonExisting()
    {
        Phake::when($this->pageMapper)->findByUri('/non-existing-page')->thenReturn(null);

        $this->assertEquals(null, $this->getPageManager()->getByUri('/non-existing-page'));
    }

    public function testGetByUri()
    {
        $page = \CMS\Services\PageManager::createPageObject('My Page', '/my-page', 'my-page');
        Phake::when($this->pageMapper)->findByUri('/my-page')->thenReturn($page);

        $this->assertEquals($page, $this->getPageManager()->getByUri('/my-page'));
    }

    public function testGetAllWithoutPage()
    {
        Phake::when($this->pageMapper)->findAll()->thenReturn(null);

        $this->assertEquals(null, $this->getPageManager()->getAll());
    }

    public function testGetAll()
    {
        $pages = array(
            \CMS\Services\PageManager::createPageObject('Page 1', '/page-1', 'page-1'),
            \CMS\Services\PageManager::createPageObject('Page 2', '/page-2', 'page-2')
        );

        Phake::when($this->pageMapper)->findAll()->thenReturn($pages);

        $this->assertEquals($pages, $this->getPageManager()->getAll());
    }

    /**
     * @expectedException Exception
     */
    public function testCreatePageWithAlreadyExistingUri()
    {
        $page1 = \CMS\Services\PageManager::createPageObject('Page 1', '/my-page', 'page-1');
        $page2 = \CMS\Services\PageManager::createPageObject('Page 2', '/my-page', 'page-2');

        Phake::when($this->pageMapper)->findByUri('/my-page')->thenReturn($page1);

        $this->getPageManager()->createPage($page2);
    }

    public function testCreatePage()
    {
        $page1 = \CMS\Services\PageManager::createPageObject('Page 1', '/page-1', 'page-1');
        $page2 = \CMS\Services\PageManager::createPageObject('Page 2', '/page-2', 'page-2');
        $page3 = \CMS\Services\PageManager::createPageObject('Page 3', '/page-3', 'page-3');

        Phake::when($this->pageMapper)->findAll()
            ->thenReturn(array($page1, $page2))
            ->thenReturn(array($page1, $page2, $page3));

        //Before create
        $this->assertEquals(array($page1, $page2), $this->getPageManager()->getAll());

        //Create
        $this->getPageManager()->createPage($page3);

        //After create
        $this->assertEquals(array($page1, $page2, $page3), $this->getPageManager()->getAll());
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingPage()
    {
        $page = \CMS\Services\PageManager::createPageObject('Test Page', '/test');
        $this->getPageManager()->updatePage($page);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdatePageWithAlreadyExistingUri()
    {
        $page1 = \CMS\Services\PageManager::createPageObject('Page 1', '/page-1', 'page-1');
        $page2 = \CMS\Services\PageManager::createPageObject('Page 2', '/page-2', 'page-2');

        Phake::when($this->pageMapper)->findByUri('/page-1')->thenReturn($page1);
        Phake::when($this->pageMapper)->findByUri('/page-2')->thenReturn($page2);
        Phake::when($this->pageMapper)->findByIdentifier('page-2')->thenReturn($page2);

        $page2->setUri('/page-1');

        $this->getPageManager()->updatePage($page2);
    }

    public function testUpdatePage()
    {
        $page = \CMS\Services\PageManager::createPageObject('Page', '/page', 'page');

        Phake::when($this->pageMapper)->findByUri('/page')->thenReturn($page);
        Phake::when($this->pageMapper)->findByIdentifier('page')->thenReturn($page);

        //Before update
        $this->assertEquals($page, $this->getPageManager()->getByIdentifier('page'));

        //Update
        $page->setName('New Page');
        $page->setUri('/page');
        $this->getPageManager()->updatePage($page);

        //After update
        $this->assertEquals('New Page', $this->getPageManager()->getByIdentifier('page')->getName());
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingPage()
    {
        $page = \CMS\Services\PageManager::createPageObject('Test Page', '/test');
        $this->getPageManager()->deletePage($page);
    }

    public function testDeletePage()
    {
        $page1 = \CMS\Services\PageManager::createPageObject('Page 1', '/page-1', 'page-1');
        $page2 = \CMS\Services\PageManager::createPageObject('Page 2', '/page-2', 'page-2');

        Phake::when($this->pageMapper)->findAll()
            ->thenReturn(array($page1, $page2))
            ->thenReturn(array($page2));
        Phake::when($this->pageMapper)->findByIdentifier('page-1')->thenReturn($page1);

        //Before delete
        $this->assertEquals(array($page1, $page2), $this->getPageManager()->getAll());

        //Delete
        $this->getPageManager()->deletePage($page1);

        //After delete
        $this->assertEquals(array($page2), $this->getPageManager()->getAll());
    }
}