<?php

use CMS\Entities\Area;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMS\Repositories\InMemory\InMemoryAreaRepository;
use CMS\Structures\AreaStructure;

class UpdateAreaInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryAreaRepository();
        $this->interactor = new UpdateAreaInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingArea()
    {
        $this->interactor->run(1, new AreaStructure());
    }

    public function testUpdateArea()
    {
        $area = $this->createSampleArea();
        $this->assertEquals('Test area', $area->getName());

        $this->interactor->run(1, new AreaStructure([
            'name' => 'Test area updated'
        ]));

        $areaUpdated = $this->repository->findByID(1);
        $this->assertEquals('Test area updated', $areaUpdated->getName());
    }

    private function createSampleArea()
    {
        $area = new Area();
        $area->setID(1);
        $area->setName('Test area');
        $this->repository->createArea($area);

        return $area;
    }

}
 