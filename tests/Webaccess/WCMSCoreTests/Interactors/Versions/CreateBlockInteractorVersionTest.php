<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Entities\Version;
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
            'areaID' => $areaID,
            'versionNumber' => 1,
        ]);
        $this->interactor->run($blockStructure);

        $page = Context::get('page_repository')->findByID($pageID);
        $this->assertEquals(2, $page->getDraftVersionID());
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setName('Page');
        $pageID = Context::get('page_repository')->createPage($page);

        $version = new Version();
        $version->setPageID($pageID);
        $version->setNumber(1);
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