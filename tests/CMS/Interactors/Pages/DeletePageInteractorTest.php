<?php

use CMS\Entities\Page;
use CMS\Interactors\Areas\DeleteAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Blocks\DeleteBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Pages\DeletePageInteractor;
use CMS\Repositories\InMemory\InMemoryAreaRepository;
use CMS\Repositories\InMemory\InMemoryBlockRepository;
use CMS\Repositories\InMemory\InMemoryPageRepository;

class DeletePageInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;
    private $areaRepository;
    private $blockRepository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryPageRepository();
        $this->areaRepository = new InMemoryAreaRepository();
        $this->blockRepository = new InMemoryBlockRepository();
        $this->interactor = new DeletePageInteractor($this->repository, new GetAreasInteractor($this->areaRepository), new GetBlocksInteractor($this->blockRepository), new DeleteAreaInteractor($this->areaRepository, $this->blockRepository), new DeleteBlockInteractor($this->blockRepository));
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingPage()
    {
        $this->interactor->run(2);
    }

    public function testDelete()
    {
        $this->createSamplePage();
        $this->assertCount(1, $this->repository->findAll());

        $this->interactor->run(1);
        $this->assertCount(0, $this->repository->findAll());
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setID(1);
        $page->setName('Test page');
        $page->setIdentifier('test-page');
        $page->setURI('/test-page');
        $this->repository->createPage($page);
    }
}
 