<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;
use Webaccess\WCMSCore\Interactors\Versions\PublishPageVersionInteractor;

class PublishPageVersionInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new PublishPageVersionInteractor();
    }

    public function testPublishPageVersion()
    {
        list($pageID, $areaID, $blockID) = $this->createSamplePage();
        $page = (new GetPageInteractor())->getPageByID($pageID);
        $blocks = (new GetBlocksInteractor())->getAllByAreaIDAndVersionNumber(1, 1);

        $this->assertEquals(1, $page->getVersionNumber());
        $this->assertEquals('<p>Hello World</p>', $blocks[0]->getHTML());

        $this->createNewPageVersion($pageID);
        $this->interactor->run(1, 2);

        $page = (new GetPageInteractor())->getPageByID($pageID);
        $blocks = (new GetBlocksInteractor())->getAllByAreaIDAndVersionNumber(2, 2);

        $this->assertEquals(2, $page->getVersionNumber());
        $this->assertEquals('<p>Hello World Updated</p>', $blocks[0]->getHTML());
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setName('Page');
        $page->setVersionNumber(1);
        $page->setDraftVersionNumber(2);
        $pageID = Context::get('page_repository')->createPage($page);

        $area = new Area();
        $area->setName('Area');
        $area->setPageID($pageID);
        $area->setVersionNumber(1);
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

    private function createNewPageVersion($pageID)
    {
        $area = new Area();
        $area->setName('Area Updated');
        $area->setPageID($pageID);
        $area->setVersionNumber(2);
        $areaID = Context::get('area_repository')->createArea($area);

        $block = new HTMLBlock();
        $block->setName('Block');
        $block->setType('html');
        $block->setHTML('<p>Hello World Updated</p>');
        $block->setAreaID($areaID);
        $block->setVersionNumber(2);
        $blockID = Context::get('block_repository')->createBlock($block);
    }
}