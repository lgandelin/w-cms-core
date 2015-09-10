<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Interactors\Pages\GetPagesInteractor;

class GetPagesInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetPagesInteractor();
    }

    public function testGetAllWithoutPages()
    {
        $this->assertCount(0, $this->interactor->getAll());
    }

    public function testGetAll()
    {
        $this->createSamplePage();
        $this->createSamplePage();

        $pages = $this->interactor->getAll();

        $this->assertEquals(2, count($pages));
        $this->assertInstanceOf('\Webaccess\WCMSCore\Entities\Page', array_shift($pages));
    }

    public function testGetAllByStructures()
    {
        $this->createSamplePage();
        $this->createSamplePage();

        $pages = $this->interactor->getAll(null, true);

        $this->assertEquals(2, count($pages));
        $this->assertInstanceOf('\Webaccess\WCMSCore\DataStructure', array_shift($pages));
    }
    private function createSamplePage()
    {
        $page = new Page();
        $page->setName('Test page');
        $page->setIdentifier('test-page');
        $page->setURI('/test-page');

        Context::get('page_repository')->createPage($page);
    }
}
