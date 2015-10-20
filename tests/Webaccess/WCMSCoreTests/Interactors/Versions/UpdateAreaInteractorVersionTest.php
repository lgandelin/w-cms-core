<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Entities\Version;
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
        list($pageID, $areaID) = $this->createSamplePage();

        $areaStructure = new DataStructure([
            'name' => 'Area test updated'
        ]);
        $this->interactor->run($areaID, $areaStructure);

        $page = Context::get('page_repository')->findByID($pageID);

        $this->assertEquals(1, $page->getVersionID());
        $this->assertEquals(2, $page->getDraftVersionID());
    }

    public function testMultipleAreaUpdates()
    {
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

        return array($pageID, $areaID);
    }
} 