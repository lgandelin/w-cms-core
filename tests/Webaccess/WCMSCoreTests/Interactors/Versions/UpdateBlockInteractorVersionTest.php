<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Entities\Page;
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
            'name' => 'Block test updated'
        ]);
        $this->interactor->run($blockID, $blockStructure);

        $page = Context::get('page_repository')->findByID($pageID);

        $this->assertEquals(1, $page->getVersionNumber());
        $this->assertEquals(2, $page->getDraftVersionNumber());
    }

    public function testMultipleBlockUpdates()
    {
        $this->assertTrue(true);
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

        $this->assertEquals(1, $page->getVersionNumber());
        $this->assertEquals(2, $page->getDraftVersionNumber());
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
        $area->setPageID($pageID);
        $areaID = Context::get('area_repository')->createArea($area);

        $block = new HTMLBlock();
        $block->setName('Block');
        $block->setType('html');
        $block->setAreaID($areaID);
        $blockID = Context::get('block_repository')->createBlock($block);

        return array($pageID, $areaID, $blockID);
    }
} 