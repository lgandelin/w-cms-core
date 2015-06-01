<?php

use CMS\Context;
use CMS\Entities\Page;
use CMS\Interactors\Areas\CreateAreaInteractor;
use CMS\Structures\AreaStructure;

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
        $area = new AreaStructure([

        ]);

        $this->interactor->run($area);
    }

    public function testCreateArea()
    {
        $this->createSamplePage();

        $area = new AreaStructure([
            'ID' => 1,
            'page_id' => 1,
            'name' => 'Test area'
        ]);

        $this->interactor->run($area);

        $this->assertEquals(1, count(Context::$areaRepository->findByPageID(1)));
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setID(1);
        $page->setName('Test page');
        Context::$pageRepository->createPage($page);
    }

    public function testCreateAreaInMasterPage()
    {
        $page = new Page();
        $page->setID(1);
        $page->setName('Master page');
        $page->setIsMaster(1);
        Context::$pageRepository->createPage($page);

        $childPage = new Page();
        $childPage->setID(2);
        $childPage->setName('Child page');
        $childPage->setMasterPageID(1);
        Context::$pageRepository->createPage($childPage);
        
        $area = new AreaStructure([
            'ID' => 1,
            'page_id' => 1,
            'name' => 'Test area',
            'is_master' => 1
        ]);
        $this->interactor->run($area);

        $this->assertEquals(1, count(Context::$areaRepository->findByPageID(2)));
    }
}
