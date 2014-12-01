<?php

use CMS\Entities\Area;
use CMS\Entities\Page;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Repositories\InMemory\InMemoryAreaRepository;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\AreaStructure;

class GetAreasInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $pageRepository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryAreaRepository();
        $this->pageRepository = new InMemoryPageRepository();
        $this->interactor = new GetAreasInteractor($this->repository, $this->pageRepository);
    }

    public function testGetAllAreas()
    {
        $this->createSamplePage();
        $this->createSampleArea();
        $this->createSampleArea();

        $areas = $this->interactor->getAll(1);
        $this->assertEquals(2, count($areas));
        $this->assertInstanceOf('\CMS\Entities\Area', $areas[0]);
    }

    public function testGetAllAreasAsStructures()
    {
        $this->createSamplePage();
        $this->createSampleArea();
        $this->createSampleArea();

        $areas = $this->interactor->getAll(1, true);
        $this->assertEquals(2, count($areas));
        $this->assertInstanceOf('\CMS\Structures\AreaStructure', $areas[0]);
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setID(1);
        $page->setName('Test page');
        $this->pageRepository->createPage($page);
    }

    private function createSampleArea()
    {
        $area = new Area();
        $area->setPageID(1);
        $this->repository->createArea($area);
    }
}
