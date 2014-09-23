<?php

use CMS\Interactors\Areas\GetAllAreasInteractor;
use CMS\Repositories\InMemory\InMemoryAreaRepository;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\AreaStructure;
use CMS\Structures\PageStructure;

class GetAllAreasInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->repository = new InMemoryAreaRepository();
        $this->pageRepository = new InMemoryPageRepository();
        $this->interactor = new GetAllAreasInteractor($this->repository, $this->pageRepository);
    }

    /**
     * @expectedException Exception
     */
    public function testGetAllAreasOfNonExistingPage()
    {
        $this->interactor->getByID(1);
    }

    public function testGetAllAreas()
    {
        $pageStructure = new PageStructure([
            'ID' => 1,
            'name' => 'Home page',
            'uri' => '/',
            'identifier' => 'home'
        ]);

        $this->pageRepository->createPage($pageStructure);

        $area1 = new AreaStructure([
            'ID' => 1,
            'name' => 'Area 1',
            'page_id' => 1
        ]);

        $area2 = new AreaStructure([
            'ID' => 2,
            'name' => 'Area 2',
            'page_id' => 1
        ]);

        $this->repository->createArea($area1);
        $this->repository->createArea($area2);

        $this->assertEquals(2, count($this->interactor->getAll(1)));
    }
}