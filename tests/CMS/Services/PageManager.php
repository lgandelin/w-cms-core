<?php

use CMS\Converters\PageConverter;
use CMS\Entities\Page;
use CMS\Services\PageManager;
use CMS\Structures\PageStructure;
    
class PageManagerTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->pageRepository = Phake::mock('\CMS\Repositories\PageRepositoryInterface');
        $this->pageConverter = new PageConverter();
    }

    private function _getPageManager()
    {
        return new PageManager($this->pageRepository);
    }
    
    private function _createPageObject($name, $uri, $identifier = null, $text = null, $meta_title = null, $meta_description = null, $meta_keywords = null)
    {
        $page = new Page();
        $page->setName($name);
        $page->setUri($uri);
        $page->setIdentifier($identifier);
        $page->setText($text);
        $page->setMetaTitle($meta_title);
        $page->setMetaDescription($meta_description);
        $page->setMetaKeywords($meta_keywords);

        return $page;
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('CMS\Services\PageManager', $this->_getPageManager());
    }

    /**
     * @expectedException Exception
     */
    public function testGetByIdentifierNonExisting()
    {
        $page = $this->_getPageManager()->getByIdentifier('my-page');
    }

    public function testGetByIdentifier()
    {
        $page = $this->_createPageObject('My Page', '/my-page', 'my-page');
        $pageS = $this->pageConverter->convertPageToPageStructure($page);

        Phake::when($this->pageRepository)->findByIdentifier('my-page')->thenReturn($page);

        $this->assertInstanceOf('CMS\Structures\PageStructure', $this->_getPageManager()->getByIdentifier('my-page'));
        $this->assertEquals($pageS, $this->_getPageManager()->getByIdentifier('my-page'));
    }

    /**
     * @expectedException Exception
     */
    public function testGetByUriNonExisting()
    {
        $this->assertEquals(null, $this->_getPageManager()->getByUri('/non-existing-page'));
    }

    public function testGetByUri()
    {
        $page = $this->_createPageObject('My Page', '/my-page', 'my-page');
        $pageS = $this->pageConverter->convertPageToPageStructure($page);

        Phake::when($this->pageRepository)->findByUri('/my-page')->thenReturn($page);

        $this->assertEquals($pageS, $this->_getPageManager()->getByUri('/my-page'));
    }

    public function testGetAllWithoutPage()
    {
        Phake::when($this->pageRepository)->findAll()->thenReturn(null);

        $this->assertEquals(null, $this->_getPageManager()->getAll());
    }

    public function testGetAll()
    {
        $page1 = $this->_createPageObject('Page 1', '/page-1', 'page-1');
        $page2 = $this->_createPageObject('Page 2', '/page-2', 'page-2');
        $page1S = $this->pageConverter->convertPageToPageStructure($page1);
        $page2S = $this->pageConverter->convertPageToPageStructure($page2);

        Phake::when($this->pageRepository)->findAll()->thenReturn([$page1, $page2]);

        $this->assertEquals([$page1S, $page2S], $this->_getPageManager()->getAll());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreatePageWithInvalidArguments()
    {
        $invalidPageS = new PageStructure([
            'name' => 'Page 3',
            'identifier' => 'page-3'
        ]);

        $this->_getPageManager()->createPage($invalidPageS);
    }

    /**
     * @expectedException Exception
     */
    public function testCreatePageWithAlreadyExistingUri()
    {
        $page1 = $this->_createPageObject('Page 1', '/my-page', 'page-1');
        $page2S = new PageStructure([
            'name' => 'Page 2',
            'uri' => '/my-page',
            'identifier' => 'page-2'
        ]);

        Phake::when($this->pageRepository)->findByUri('/my-page')->thenReturn($page1);
        Phake::when($this->pageRepository)->findByIdentifier('page-1')->thenReturn($page1);

        $this->_getPageManager()->createPage($page2S);
    }

    public function testCreatePage()
    {
        $page1 = $this->_createPageObject('Page 1', '/page-1', 'page-1');
        $page2 = $this->_createPageObject('Page 2', '/page-2', 'page-2');
        $page3 = $this->_createPageObject('Page 3', '/page-3', 'page-3');
        $page1S = $this->pageConverter->convertPageToPageStructure($page1);
        $page2S = $this->pageConverter->convertPageToPageStructure($page2);
        $page3S = $this->pageConverter->convertPageToPageStructure($page3);

        Phake::when($this->pageRepository)->findAll()->thenReturn([$page1, $page2]);

        //Before create
        $this->assertEquals([$page1S, $page2S], $this->_getPageManager()->getAll());

        //Create
        $this->_getPageManager()->createPage($page3S);

        Phake::when($this->pageRepository)->findAll()->thenReturn([$page1, $page2, $page3]);

        //After create
        $this->assertEquals([$page1S, $page2S, $page3S], $this->_getPageManager()->getAll());
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingPage()
    {
        $pageS = new PageStructure([
            'name' => 'Page',
            'uri' => '/page',
            'identifier' => 'page'
        ]);

        $this->_getPageManager()->updatePage($pageS);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdatePageWithAlreadyExistingUri()
    {
        $page1 = $this->_createPageObject('Page 1', '/page-1', 'page-1');
        $page2 = $this->_createPageObject('Page 2', '/page-2', 'page-2');
        $page2S = $this->pageConverter->convertPageToPageStructure($page2);

        Phake::when($this->pageRepository)->findByUri('/page-1')->thenReturn($page1);

        $this->_getPageManager()->updatePage($page2S);
    }

    public function testUpdatePage()
    {
        $page = $this->_createPageObject('My Page', '/my-page', 'my-page');
        $pageS = $this->pageConverter->convertPageToPageStructure($page);
        $pageUpdated = $this->_createPageObject('New Page', '/my-page', 'my-page');
        $pageUpdatedS = $this->pageConverter->convertPageToPageStructure($pageUpdated);

        Phake::when($this->pageRepository)->findByIdentifier('my-page')->thenReturn($page)->thenReturn($pageUpdated);

        //Before update
        $this->assertEquals($pageS, $this->_getPageManager()->getByIdentifier('my-page'));

        //Update
        $this->_getPageManager()->updatePage($pageUpdatedS);

        //After update
        $this->assertEquals($pageUpdatedS, $this->_getPageManager()->getByIdentifier('my-page'));
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingPage()
    {
        $this->_getPageManager()->deletePage('my-page');
    }

    public function testDeletePage()
    {
        $page1 = $this->_createPageObject('Page 1', '/page-1', 'page-1');
        $page2 = $this->_createPageObject('Page 2', '/page-2', 'page-2');
        $page1S = $this->pageConverter->convertPageToPageStructure($page1);
        $page2S = $this->pageConverter->convertPageToPageStructure($page2);


        Phake::when($this->pageRepository)->findAll()
            ->thenReturn([$page1, $page2])
            ->thenReturn([$page2]);
        Phake::when($this->pageRepository)->findByIdentifier('page-1')->thenReturn($page1);

        //Before delete
        $this->assertEquals([$page1S, $page2S], $this->_getPageManager()->getAll());

        //Delete
        $this->_getPageManager()->deletePage('page-1');

        //After delete
        $this->assertEquals([$page2S], $this->_getPageManager()->getAll());
    }

    /**
     * @expectedException Exception
     */
    public function testDuplicateNonExistingPage()
    {
        $this->_getPageManager()->duplicatePage('my-page');
    }

    public function testDuplicatePage()
    {
        $page1 = $this->_createPageObject('Page 1', '/page-1', 'page-1');
        $page2 = $this->_createPageObject('Page 2', '/page-2', 'page-2');
        $page2Duplicate = $this->_createPageObject('Page 2 - COPY', '/page-2-copy', 'page-2-copy');
        $page1S = $this->pageConverter->convertPageToPageStructure($page1);
        $page2S = $this->pageConverter->convertPageToPageStructure($page2);
        $page2DuplicateS = $this->pageConverter->convertPageToPageStructure($page2Duplicate);

        Phake::when($this->pageRepository)->findByIdentifier('page-2')->thenReturn($page2);
        Phake::when($this->pageRepository)->findAll()
            ->thenReturn([$page1, $page2])
            ->thenReturn([$page1, $page2, $page2Duplicate]);

        //Before duplicate
        $this->assertEquals([$page1S, $page2S], $this->_getPageManager()->getAll());

        //Duplicate
        $this->_getPageManager()->duplicatePage('page-2');

        //After duplicate
        $this->assertEquals([$page1S, $page2S, $page2DuplicateS], $this->_getPageManager()->getAll());
    }
}