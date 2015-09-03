<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Interactors\Pages\DuplicatePageInteractor;

class DuplicatePageInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new DuplicatePageInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testDuplicateNonExistingPage()
    {
        $this->interactor->run(2);
    }

    /*public function testDuplicatePage()
    {
        $pageID = $this->createSamplePage();
        $area1ID = $this->createSampleArea($pageID);
        $area2ID = $this->createSampleArea($pageID);
        $this->createSampleBlock($area1ID);
        $this->createSampleBlock($area1ID);
        $this->createSampleBlock($area1ID);
        $this->createSampleBlock($area2ID);

        $this->assertCount(1, Context::get('page')->findAll());

        $this->interactor->run($pageID);

        $this->assertCount(2, Context::get('page')->findAll());
        $pageDuplicated = Context::get('page')->findByIdentifier('test-page-copy');

        $this->assertEquals($pageDuplicated->getName(), 'Test page - COPY');
        $this->assertEquals($pageDuplicated->getURI(), '/test-page-copy');
        $this->assertEquals($pageDuplicated->getIdentifier(), 'test-page-copy');

        $this->assertEquals(2, count(Context::get('area')->findByPageID($pageID)));
        $this->assertEquals(3, count(Context::get('block')->findByAreaID($area1ID)));
    }*/

    private function createSamplePage()
    {
        $page = new Page();
        $page->setName('Test page');
        $page->setIdentifier('test-page');
        $page->setURI('/test-page');

        return Context::get('page')->createPage($page);
    }

    private function createSampleArea($pageID)
    {
        $area = new Area();
        $area->setPageID($pageID);
        $area->setName('Test area');

        return Context::get('area')->createArea($area);
    }

    private function createSampleBlock($areaID)
    {
        $block = new HTMLBlock();
        $block->setName('Test block');
        $block->setAreaID($areaID);
        $block->setType('html');

        return Context::get('block')->createBlock($block);
    }
}
