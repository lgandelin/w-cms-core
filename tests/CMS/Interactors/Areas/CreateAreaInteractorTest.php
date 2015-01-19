<?php

use CMS\Entities\Page;
use CMS\Interactors\Areas\CreateAreaInteractor;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Interactors\Pages\GetPagesInteractor;
use CMS\Repositories\InMemory\InMemoryAreaRepository;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\AreaStructure;

class AddAreaInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $pageRepository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryAreaRepository();
        $this->pageRepository = new InMemoryPageRepository();
        $this->interactor = new CreateAreaInteractor($this->repository, new GetPagesInteractor($this->pageRepository), new GetPageInteractor($this->pageRepository));
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

        $this->assertEquals(1, count($this->repository->findByPageID(1)));
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setID(1);
        $page->setName('Test page');
        $this->pageRepository->createPage($page);
    }

    public function testCreateAreaInMasterPage()
    {
        $page = new Page();
        $page->setID(1);
        $page->setName('Master page');
        $page->setIsMaster(1);
        $this->pageRepository->createPage($page);

        $childPage = new Page();
        $childPage->setID(2);
        $childPage->setName('Child page');
        $childPage->setMasterPageID(1);
        $this->pageRepository->createPage($childPage);
        
        $area = new AreaStructure([
            'ID' => 1,
            'page_id' => 1,
            'name' => 'Test area',
            'is_master' => 1
        ]);
        $this->interactor->run($area);

        $this->assertEquals(1, count($this->repository->findByPageID(2)));
    }
}
