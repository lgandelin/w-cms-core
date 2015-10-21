<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Entities\Version;
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

        $this->assertEquals(1, $page->getVersionID());
        $this->assertEquals('<p>Hello World</p>', $blocks[0]->getHTML());

        $this->createNewPageVersion($page);
        $this->interactor->run(1, 2);

        $page = (new GetPageInteractor())->getPageByID($pageID);
        $blocks = (new GetBlocksInteractor())->getAllByAreaIDAndVersionNumber(2, 2);

        $this->assertEquals(2, $page->getVersionID());
        $this->assertEquals('<p>Hello World Updated</p>', $blocks[0]->getHTML());
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setName('Page');
        $pageID = Context::get('page_repository')->createPage($page);

        $version = new Version();
        $version->setNumber(1);
        $version->setPageID($pageID);
        $versionID = Context::get('version_repository')->createVersion($version);

        $page->setVersionID($versionID);
        $page->setDraftVersionID($versionID);
        Context::get('page_repository')->updatePage($page);

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

    private function createNewPageVersion($page)
    {
        $version = new Version();
        $version->setNumber(2);
        $version->setPageID($page->getID());
        $versionID = Context::get('version_repository')->createVersion($version);

        $page->setVersionID($versionID);
        $page->setDraftVersionID($versionID);
        Context::get('page_repository')->updatePage($page);

        $area = new Area();
        $area->setName('Area Updated');
        $area->setPageID($page->getID());
        $area->setVersionNumber($version->getNumber());
        $areaID = Context::get('area_repository')->createArea($area);

        $block = new HTMLBlock();
        $block->setName('Block');
        $block->setType('html');
        $block->setHTML('<p>Hello World Updated</p>');
        $block->setAreaID($areaID);
        $block->setVersionNumber($version->getNumber());
        $blockID = Context::get('block_repository')->createBlock($block);
    }
}