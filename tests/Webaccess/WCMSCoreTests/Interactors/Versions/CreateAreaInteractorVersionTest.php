<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\Page;
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
            'page_id' => $pageID
        ]);
        $this->interactor->run($areaStructure);
        $page = Context::get('page_repository')->findByID($pageID);

        $this->assertEquals(2, $page->getDraftVersionNumber());
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setName('Page');
        $page->setVersionNumber(1);
        $page->setDraftVersionNumber(1);

        return Context::get('page_repository')->createPage($page);
    }
} 