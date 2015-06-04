<?php

use CMS\Context;
use CMS\Entities\Area;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Entities\Page;
use CMS\Interactors\Pages\DuplicatePageInteractor;

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

    public function testDuplicatePage()
    {
        $pageID = $this->createSamplePage();
        $area1ID = $this->createSampleArea($pageID);
        $area2ID = $this->createSampleArea($pageID);
        $this->createSampleBlock($area1ID);
        $this->createSampleBlock($area1ID);
        $this->createSampleBlock($area1ID);
        $this->createSampleBlock($area2ID);

        $this->assertCount(1, Context::$pageRepository->findAll());

        $this->interactor->run($pageID);

        $this->assertCount(2, Context::$pageRepository->findAll());
        $pageDuplicated = Context::$pageRepository->findByIdentifier('test-page-copy');

        $this->assertEquals($pageDuplicated->getName(), 'Test page - COPY');
        $this->assertEquals($pageDuplicated->getURI(), '/test-page-copy');
        $this->assertEquals($pageDuplicated->getIdentifier(), 'test-page-copy');

        $this->assertEquals(2, count(Context::$areaRepository->findByPageID($pageID)));
        $this->assertEquals(3, count(Context::$blockRepository->findByAreaID($area1ID)));
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setName('Test page');
        $page->setIdentifier('test-page');
        $page->setURI('/test-page');

        return Context::$pageRepository->createPage($page);
    }

    private function createSampleArea($pageID)
    {
        $area = new Area();
        $area->setPageID($pageID);
        $area->setName('Test area');

        return Context::$areaRepository->createArea($area);
    }

    private function createSampleBlock($areaID)
    {
        $block = new HTMLBlock();
        $block->setName('Test block');
        $block->setAreaID($areaID);
        $block->setType('html');

        return Context::$blockRepository->createBlock($block);
    }
}
