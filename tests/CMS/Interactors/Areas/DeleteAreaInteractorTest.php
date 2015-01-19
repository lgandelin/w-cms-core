<?php

use CMS\Entities\Area;
use CMS\Entities\Block;
use CMS\Interactors\Areas\DeleteAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Blocks\DeleteBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Repositories\InMemory\InMemoryAreaRepository;
use CMS\Repositories\InMemory\InMemoryBlockRepository;

class DeleteAreaInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $blockRepository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryAreaRepository();
        $this->blockRepository = new InMemoryBlockRepository();
        $this->interactor = new DeleteAreaInteractor(
            $this->repository,
            new GetAreasInteractor($this->repository),
            new GetBlocksInteractor($this->blockRepository),
            new DeleteBlockInteractor($this->blockRepository, new GetBlocksInteractor($this->blockRepository))
        );
    }

    public function testDelete()
    {
        $areaID = $this->createSampleArea();
        $this->assertEquals(1, sizeof($this->repository->findAll()));

        $this->interactor->run($areaID);

        $this->assertEquals(0, sizeof($this->repository->findAll()));
    }

    private function createSampleArea()
    {
        $area = new Area();
        $area->setName('Test area');

        return $this->repository->createArea($area);
    }

    public function testDeleteMasterArea()
    {
        $area = new Area();
        $area->setID(2);
        $area->setName('Area');
        $area->setIsMaster(1);
        $this->repository->createArea($area);

        $childArea = new Area();
        $childArea->setID(2);
        $childArea->setName('Child area');
        $childArea->setMasterAreaID(1);
        $this->repository->createArea($childArea);

        $this->interactor->run(1);

        $this->assertFalse($this->repository->findByID(2));
    }
}
