<?php

use CMS\Entities\Area;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMS\Repositories\InMemory\InMemoryAreaRepository;
use CMS\Structures\AreaStructure;

class UpdateAreaInteractorTest extends PHPUnit_Framework_TestCase
{
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
        $areaID = $this->createSampleArea();

        $this->interactor->run($areaID, new AreaStructure([
            'name' => 'Test area updated'
        ]));

        $areaUpdated = $this->repository->findByID($areaID);
        $this->assertEquals('Test area updated', $areaUpdated->getName());
    }

    private function createSampleArea()
    {
        $area = new Area();
        $area->setName('Test area');

        return $this->repository->createArea($area);
    }
}
