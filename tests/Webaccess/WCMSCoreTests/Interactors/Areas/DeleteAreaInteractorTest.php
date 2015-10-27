<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Entities\Version;
use Webaccess\WCMSCore\Interactors\Areas\DeleteAreaInteractor;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;

class DeleteAreaInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp()
    {
        CMSTestsSuite::clean();
        $this->interactor = new DeleteAreaInteractor();
    }

    public function testDelete()
    {
        $areaID = $this->createSampleArea();
        $this->assertEquals(1, sizeof((new GetAreasInteractor())->getByPageIDAndVersionNumber(1, 1)));

        $this->interactor->run($areaID, false);

        $this->assertEquals(0, sizeof((new GetAreasInteractor())->getByPageIDAndVersionNumber(1, 2)));
    }

    private function createSampleArea()
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

        return Context::get('area_repository')->createArea($area);
    }

    public function testDeleteMasterArea()
    {
        $area = new Area();
        $area->setID(2);
        $area->setName('Area');
        $area->setIsMaster(1);
        Context::get('area_repository')->createArea($area);

        $childArea = new Area();
        $childArea->setID(2);
        $childArea->setName('Child area');
        $childArea->setMasterAreaID(1);
        Context::get('area_repository')->createArea($childArea);

        $this->interactor->run(1);

        $this->assertFalse(Context::get('area_repository')->findByID(3));
    }
}