<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Interactors\Blocks\CreateBlockInteractor;

class CreateBlockInteractorVersionTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateBlockInteractor();
    }

    public function testCreateBlock()
    {
        $this->assertTrue(true);
        list($pageID, $areaID) = $this->createSamplePage();

        $blockStructure = new DataStructure([
            'name' => 'Block',
            'area_id' => $areaID
        ]);
        $this->interactor->run($blockStructure);
        $page = Context::get('page_repository')->findByID($pageID);

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

        return array($pageID, $areaID);
    }
} 