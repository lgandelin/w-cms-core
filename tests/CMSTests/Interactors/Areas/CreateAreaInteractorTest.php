<?php

use CMS\Context;
use CMS\Entities\Page;
use CMS\Interactors\Areas\CreateAreaInteractor;
use CMS\DataStructure;

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

        ]);

        $this->interactor->run($area);
    }

    public function testCreateArea()
    {
        $this->createSamplePage();

        $area = new DataStructure([
            'ID' => 1,
            'page_id' => 1,
            'name' => 'Test area'
        ]);

        $this->interactor->run($area);

        $this->assertEquals(1, count(Context::getRepository('area')->findByPageID(1)));
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setID(1);
        $page->setName('Test page');
        Context::getRepository('page')->createPage($page);
    }

    public function testCreateAreaInMasterPage()
    {
        $page = new Page();
        $page->setID(1);
        $page->setName('Master page');
        $page->setIsMaster(1);
        Context::getRepository('page')->createPage($page);

        $childPage = new Page();
        $childPage->setID(2);
        $childPage->setName('Child page');
        $childPage->setMasterPageID(1);
        Context::getRepository('page')->createPage($childPage);
        
        $area = new DataStructure([
            'ID' => 1,
            'page_id' => 1,
            'name' => 'Test area',
            'is_master' => 1
        ]);
        $this->interactor->run($area);

        $this->assertEquals(1, count(Context::getRepository('area')->findByPageID(2)));
    }
}
