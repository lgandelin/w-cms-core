<?php

use CMS\Entities\Area;
use CMS\Interactors\Areas\GetAreaInteractor;
use CMS\Repositories\InMemory\InMemoryAreaRepository;
use CMS\Structures\AreaStructure;

class GetAreaInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryAreaRepository();
        $this->interactor = new GetAreaInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingArea()
    {
        $this->interactor->getAreaByID(1);
    }

    public function testGetArea()
    {
        $this->createSampleArea();

        $this->assertInstanceOf('\CMS\Entities\Area', $this->interactor->getAreaByID(1));
    }

    public function testGetAreaAsStructure()
    {
        $this->createSampleArea();

        $this->assertInstanceOf('\CMS\Structures\AreaStructure', $this->interactor->getAreaByID(1, true));
    }

    private function createSampleArea()
    {
        $area = new Area();
        $area->setID(1);
        $this->repository->createArea($area);
    }
}