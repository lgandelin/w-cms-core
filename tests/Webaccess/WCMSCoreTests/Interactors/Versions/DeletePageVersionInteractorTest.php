<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;
use Webaccess\WCMSCore\Interactors\Versions\DeletePageVersionInteractor;

class DeletePageVersionInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new DeletePageVersionInteractor();
    }

    public function testDeletePageVersion()
    {
        list($pageID, $areaID, $blockID) = $this->createSamplePage();
        $blocks = (new GetBlocksInteractor())->getAllByAreaIDAndVersionNumber(1, 1);
        $this->assertEquals(1, count($blocks));

        $this->interactor->run(1, 1);

        $blocks = (new GetBlocksInteractor())->getAllByAreaIDAndVersionNumber(1, 1);
        $this->assertEquals(0, count($blocks));
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setName('Page');
        $page->setVersionNumber(1);
        $page->setDraftVersionNumber(1);
        $pageID = Context::get('page_repository')->createPage($page);

        $area = new Area();
        $area->setName('Area');
        $area->setVersionNumber(1);
        $area->setPageID($pageID);
        $areaID = Context::get('area_repository')->createArea($area);

        $block = new HTMLBlock();
        $block->setName('Block');
        $block->setType('html');
        $block->setHTML('<p>Hello World</p>');
        $block->setAreaID($areaID);
        $block->setVersionNumber(1);
        $blockID = Context::get('block_repository')->createBlock($block);

        return array($pageID, $areaID, $blockID);
    }
}