<?php

use CMS\Entities\Area;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMSTests\Repositories\InMemoryAreaRepository;
use CMS\Structures\AreaStructure;

class UpdateAreaInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryAreaRepository();
        $this->interactor = new UpdateAreaInteractor(
            $this->repository,
            new GetAreasInteractor($this->repository)
        );
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

    public function testUpdateMasterArea()
    {
        $masterArea = new Area();
        $masterArea->setID(1);
        $masterArea->setIsMaster(true);
        $masterArea->setName('Test area');
        $this->repository->createArea($masterArea);

        $childArea1 = new Area();
        $childArea1->setID(2);
        $childArea1->setMasterAreaID($masterArea->getID());
        $childArea1->setName('Test area');
        $this->repository->createArea($childArea1);

        $childArea2 = new Area();
        $childArea2->setID(3);
        $childArea2->setMasterAreaID($masterArea->getID());
        $childArea2->setName('Test area');
        $this->repository->createArea($childArea2);

        $areaStructure = new AreaStructure([
            'name' => 'Test area updated'
        ]);
        $this->interactor->run($masterArea->getID(), $areaStructure);

        $childArea1 = $this->repository->findByID($childArea1->getID());
        $childArea2 = $this->repository->findByID($childArea2->getID());

        $this->assertEquals('Test area updated', $childArea1->getName());
        $this->assertEquals('Test area updated', $childArea2->getName());
    }
}
