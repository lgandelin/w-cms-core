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
        $this->createSamplePage(1);
        $this->createSampleArea(1, 1);
        $this->createSampleArea(2, 1);
        $this->createSampleBlock(1, 1);
        $this->createSampleBlock(2, 1);
        $this->createSampleBlock(3, 1);
        $this->createSampleBlock(4, 2);

        $this->assertCount(1, Context::$pageRepository->findAll());

        $this->interactor->run(1);

        $this->assertCount(2, Context::$pageRepository->findAll());
        $pageDuplicated = Context::$pageRepository->findByIdentifier('test-page-copy');

        $this->assertEquals($pageDuplicated->getName(), 'Test page - COPY');
        $this->assertEquals($pageDuplicated->getURI(), '/test-page-copy');
        $this->assertEquals($pageDuplicated->getIdentifier(), 'test-page-copy');

        $this->assertEquals(2, count(Context::$areaRepository->findByPageID(1)));
        $this->assertEquals(3, count(Context::$blockRepository->findByAreaID(1)));
    }

    private function createSamplePage($pageID)
    {
        $page = new Page();
        $page->setID($pageID);
        $page->setName('Test page');
        $page->setIdentifier('test-page');
        $page->setURI('/test-page');
        Context::$pageRepository->createPage($page);
    }

    private function createSampleArea($areaID, $pageID)
    {
        $area = new Area();
        $area->setID($areaID);
        $area->setPageID($pageID);
        $area->setName('Test area ' . $areaID);

        Context::$areaRepository->createArea($area);
    }

    private function createSampleBlock($blockID, $areaID)
    {
        $block = new HTMLBlock();
        $block->setName('Test block ' . $blockID);
        $block->setAreaID($areaID);
        $block->setType('html');

        Context::$blockRepository->createBlock($block);
    }
}
