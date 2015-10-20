<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Entities\Version;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\UpdateBlockInteractor;

class UpdateBlockInteractorVersionTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new UpdateBlockInteractor();
    }

    public function testUpdateBlock()
    {
        $this->assertTrue(true);
        list($pageID, $areaID, $blockID) = $this->createSamplePage();

        $blockStructure = new DataStructure([
            'name' => 'Block updated',
            'html' => '<p>Hello World updated</p>'
        ]);
        $this->interactor->run($blockID, $blockStructure);

        $page = Context::get('page_repository')->findByID($pageID);

        //Check that the page draft version has been bumped
        $this->assertEquals(1, $page->getVersionID());
        $this->assertEquals(2, $page->getDraftVersionID());

        //Check that the areas have been duplicated
        $areasNewVersion = (new GetAreasInteractor())->getByPageIDAndVersionNumber($pageID, 2);
        $this->assertEquals($areasNewVersion[0]->getVersionNumber(), 2);
        $this->assertEquals($areasNewVersion[0]->getID(), 2);
        $blocksNewVersion = (new GetBlocksInteractor())->getAllByAreaIDAndVersionNumber(2, 2);

        //Check that the blocks have been duplicated
        $this->assertEquals($blocksNewVersion[0]->getVersionNumber(), 2);
        $this->assertEquals('Block updated', $blocksNewVersion[0]->getName());
        $this->assertEquals('<p>Hello World updated</p>', $blocksNewVersion[0]->getHTML());
    }

    public function testMultipleBlockUpdates()
    {
        list($pageID, $areaID, $blockID) = $this->createSamplePage();

        $blockStructure = new DataStructure([
            'name' => 'Block test updated'
        ]);
        $this->interactor->run($blockID, $blockStructure);

        $blockStructure = new DataStructure([
            'name' => 'Block test updated again'
        ]);
        $this->interactor->run($blockID, $blockStructure);

        $page = Context::get('page_repository')->findByID($pageID);

        $this->assertEquals(1, $page->getVersionID());
        $this->assertEquals(2, $page->getDraftVersionID());
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
}