<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Entities\Version;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;
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
        list($pageID, $versionID, $areaID, $blockID) = $this->createSamplePage();
        $blocks = (new GetAreasInteractor())->getByPageIDAndVersionNumber($pageID, 1);
        $this->assertEquals(1, count($blocks));

        $this->interactor->run($pageID, 1);

        $blocks = (new GetAreasInteractor())->getByPageIDAndVersionNumber($pageID, 1);
        $this->assertEquals(0, count($blocks));
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

        return array($pageID, $versionID, $areaID, $blockID);
    }
}