<?php

use CMS\Entities\Area;
use CMS\Interactors\Areas\GetAreaInteractor;
use CMSTests\Repositories\InMemoryAreaRepository;
use CMS\Structures\AreaStructure;

class GetAreaInteractorTest extends PHPUnit_Framework_TestCase
{
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
        $areaID = $this->createSampleArea();

        $this->assertInstanceOf('\CMS\Entities\Area', $this->interactor->getAreaByID($areaID));
    }

    public function testGetAreaAsStructure()
    {
        $areaID = $this->createSampleArea();

        $this->assertInstanceOf('\CMS\Structures\AreaStructure', $this->interactor->getAreaByID($areaID, true));
    }

    private function createSampleArea()
    {
        $area = new Area();

        return $this->repository->createArea($area);
    }
}
