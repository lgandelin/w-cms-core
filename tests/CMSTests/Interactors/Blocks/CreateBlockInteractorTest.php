<?php

use CMS\Entities\Area;
use CMS\Entities\Block;
use CMS\Interactors\Areas\GetAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMSTests\Repositories\InMemoryAreaRepository;
use CMSTests\Repositories\InMemoryBlockRepository;
use CMS\Structures\BlockStructure;

class CreateBlockInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryBlockRepository();
        $this->areaRepository = new InMemoryAreaRepository();
        $this->interactor = new CreateBlockInteractor(
            $this->repository,
            new GetAreasInteractor($this->areaRepository)
        );
    }

    /**
     * @expectedException Exception
     */
    public function testCreateInvalidBlock()
    {
        $block = new BlockStructure([

        ]);

        $this->interactor->run($block);
    }

    public function testCreate()
    {
        $area = new Area();
        $area->setID(1);
        $area->setName('Area');
        $this->areaRepository->createArea($area);

        $block = new BlockStructure([
            'name' => 'Test block',
            'area_id' => 1
        ]);

        $this->interactor->run($block);

        $this->assertEquals(1, count($this->repository->findAll()));
        $this->assertEquals(1, count($this->repository->findByAreaID(1)));
    }

    public function testCreateBlockInMasterPage()
    {
        $area = new Area();
        $area->setID(1);
        $area->setName('Master area');
        $area->setIsMaster(1);
        $this->areaRepository->createArea($area);

        $childArea = new Area();
        $childArea->setID(2);
        $childArea->setName('Child area');
        $childArea->setMasterAreaID(1);
        $this->areaRepository->createArea($childArea);

        $block = new BlockStructure([
            'name' => 'Test block',
            'area_id' => 1,
            'is_master' => 1
        ]);
        $this->interactor->run($block);

        $this->assertEquals(1, count($this->repository->findByAreaID(2)));
    }
}
