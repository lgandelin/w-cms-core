<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Entities\Version;
use Webaccess\WCMSCore\Interactors\Areas\CreateAreaInteractor;

class CreateAreaInteractorVersionTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateAreaInteractor();
    }

    public function testCreateArea()
    {
        $this->assertTrue(true);
        $pageID = $this->createSamplePage();

        $areaStructure = new DataStructure([
            'name' => 'Area',
            'pageID' => $pageID
        ]);
        $this->interactor->run($areaStructure);
        $page = Context::get('page_repository')->findByID($pageID);

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

        return $pageID;
    }
} 