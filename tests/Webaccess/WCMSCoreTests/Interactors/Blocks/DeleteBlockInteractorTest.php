<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Entities\Version;
use Webaccess\WCMSCore\Interactors\Blocks\DeleteBlockInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;

class DeleteBlockInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new DeleteBlockInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingBlock()
    {
        $this->interactor->run(1);
    }

    public function testDelete()
    {
        $blockID = $this->createSampleBlock();
        $this->assertEquals(1, sizeof((new GetBlocksInteractor())->getAllByAreaID(1)));

        $this->interactor->run($blockID, false);

        $this->assertEquals(0, sizeof((new GetBlocksInteractor())->getAllByAreaID(1)));
    }

    private function createSampleBlock()
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
        $area->setName('Test area');
        $area->setPageID(1);
        $area->setVersionNumber(1);

        $areaID = Context::get('area_repository')->createArea($area);

        $block = new HTMLBlock();
        $block->setName('Block');
        $block->setAreaID($areaID);
        $block->setVersionNumber(1);

        return Context::get('block_repository')->createBlock($block);
    }

    public function testDeleteMasterBlock()
    {
        $block = new HTMLBlock();
        $block->setName('Block');
        $block->setIsMaster(1);
        Context::get('block_repository')->createBlock($block);

        $childBlock = new HTMLBlock();
        $childBlock->setName('Child block');
        $childBlock->setMasterBlockID(1);
        Context::get('block_repository')->createBlock($childBlock);

        $this->interactor->run(1);

        $this->assertFalse(Context::get('block_repository')->findByID(2));
    }
}
