<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Interactors\Areas\UpdateAreaInteractor;

class UpdateAreaInteractorVersionTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new UpdateAreaInteractor();
    }

    public function testUpdateArea()
    {
        $this->assertTrue(true);
        list($pageID, $areaID) = $this->createSamplePage();

        $areaStructure = new DataStructure([
            'name' => 'Area test updated'
        ]);
        $this->interactor->run($areaID, $areaStructure);

        $page = Context::get('page_repository')->findByID($pageID);

        $this->assertEquals(1, $page->getVersionNumber());
        $this->assertEquals(2, $page->getDraftVersionNumber());
    }

    public function testMultipleBlockUpdates()
    {
        $this->assertTrue(true);
        list($pageID, $areaID) = $this->createSamplePage();

        $areaStructure = new DataStructure([
            'name' => 'Area test updated'
        ]);
        $this->interactor->run($areaID, $areaStructure);

        $areaStructure = new DataStructure([
            'name' => 'Area test updated again'
        ]);
        $this->interactor->run($areaID, $areaStructure);

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

        return array($pageID, $areaID);
    }
} 