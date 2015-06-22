<?php

use CMS\Context;
use CMS\Entities\Area;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Entities\Page;
use CMS\Interactors\Pages\DeletePageInteractor;

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
        $this->assertCount(1, Context::getRepository('page')->findAll());

        $this->interactor->run($pageID);
        $this->assertCount(0, Context::getRepository('page')->findAll());
    }

    public function testDeleteAlongWithAreasAndBlocks()
    {
        $pageID = $this->createSamplePage();
        $areaID = $this->createSampleArea($pageID);
        $this->createSampleBlock($areaID);
        $this->createSampleBlock($areaID);
        $this->createSampleBlock($areaID);

        $this->assertCount(1, Context::getRepository('page')->findAll());
        $this->assertCount(1, Context::getRepository('area')->findAll($pageID));
        $this->assertCount(3, Context::getRepository('block')->findAll($areaID));

        $this->interactor->run($pageID);

        $this->assertCount(0, Context::getRepository('page')->findAll());
        $this->assertCount(0, Context::getRepository('area')->findAll());
        $this->assertCount(0, Context::getRepository('block')->findAll());
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setName('Test page');
        $page->setIdentifier('test-page');
        $page->setURI('/test-page');

        return Context::getRepository('page')->createPage($page);
    }

    private function createSampleArea($pageID)
    {
        $area = new Area();
        $area->setPageID($pageID);
        $area->setName('Test area');

        return Context::getRepository('area')->createArea($area);
    }

    private function createSampleBlock($areaID)
    {
        $block = new HTMLBlock();
        $block->setName('Test block');
        $block->setAreaID($areaID);
        $block->setType('html');

        return Context::getRepository('block')->createBlock($block);
    }
}
