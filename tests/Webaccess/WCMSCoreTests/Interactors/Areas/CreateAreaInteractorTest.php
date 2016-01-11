<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Interactors\Areas\CreateAreaInteractor;
use Webaccess\WCMSCore\DataStructure;

class CreateAreaInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp()
    {
        CMSTestsSuite::clean();
        $this->interactor = new CreateAreaInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testCreateInvalidArea()
    {
        $area = new DataStructure([
            'pageID' => null,
        ]);

        $this->interactor->run($area);
    }

    public function testCreateArea()
    {
        $this->createSamplePage();

        $area = new DataStructure([
            'ID' => 1,
            'pageID' => 1,
            'name' => 'Test area'
        ]);

        $this->interactor->run($area);

        $this->assertEquals(1, count(Context::get('area_repository')->findByPageID(1)));
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setID(1);
        $page->setName('Test page');
        Context::get('page_repository')->createPage($page);
    }

    /*public function testCreateAreaInMasterPage()
    {
        $page = new Page();
        $page->setID(1);
        $page->setName('Master page');
        $page->setIsMaster(1);
        Context::get('page_repository')->createPage($page);

        $childPage = new Page();
        $childPage->setID(2);
        $childPage->setName('Child page');
        $childPage->setMasterPageID(1);
        Context::get('page_repository')->createPage($childPage);

        $area = new DataStructure([
            'ID' => 1,
            'pageID' => 1,
            'name' => 'Test area',
            'isMaster' => 1
        ]);
        $this->interactor->run($area);

        $this->assertEquals(1, count(Context::get('area_repository')->findByPageID(2)));
    }*/
}
