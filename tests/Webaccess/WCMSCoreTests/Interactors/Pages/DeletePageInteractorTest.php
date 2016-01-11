<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Interactors\Pages\DeletePageInteractor;

class DeletePageInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new DeletePageInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingPage()
    {
        $this->interactor->run(2);
    }

    public function testDelete()
    {
        $pageID = $this->createSamplePage();
        $this->assertCount(1, Context::get('page_repository')->findAll());

        $this->interactor->run($pageID);
        $this->assertCount(0, Context::get('page_repository')->findAll());
    }

    /*public function testDeleteAlongWithAreasAndBlocks()
    {
        $pageID = $this->createSamplePage();
        $areaID = $this->createSampleArea($pageID);
        $this->createSampleBlock($areaID);
        $this->createSampleBlock($areaID);
        $this->createSampleBlock($areaID);

        $this->assertCount(1, Context::get('page_repository')->findAll());
        $this->assertCount(1, Context::get('area_repository')->findAll($pageID));
        $this->assertCount(3, Context::get('block_repository')->findAll($areaID));

        $this->interactor->run($pageID);

        $this->assertCount(0, Context::get('page_repository')->findAll());
        $this->assertCount(0, Context::get('area_repository')->findAll());
        $this->assertCount(0, Context::get('block_repository')->findAll());
    }*/

    private function createSamplePage()
    {
        $page = new Page();
        $page->setName('Test page');
        $page->setIdentifier('test-page');
        $page->setURI('/test-page');

        return Context::get('page_repository')->createPage($page);
    }

    private function createSampleArea($pageID)
    {
        $area = new Area();
        $area->setPageID($pageID);
        $area->setName('Test area');

        return Context::get('area_repository')->createArea($area);
    }

    private function createSampleBlock($areaID)
    {
        $block = new HTMLBlock();
        $block->setName('Test block');
        $block->setAreaID($areaID);
        $block->setType('html');

        return Context::get('block_repository')->createBlock($block);
    }
}
