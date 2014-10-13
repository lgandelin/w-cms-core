<?php

use CMS\Entities\Area;
use CMS\Entities\Block;
use CMS\Interactors\Areas\DeleteAreaInteractor;
use CMS\Repositories\InMemory\InMemoryAreaRepository;
use CMS\Repositories\InMemory\InMemoryBlockRepository;

class DeleteAreaInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;
    private $blockRepository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryAreaRepository();
        $this->blockRepository = new InMemoryBlockRepository();
        $this->interactor = new DeleteAreaInteractor($this->repository, $this->blockRepository);
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteAreaWithBlocksInside()
    {
        $this->createSampleArea(1);
        $this->createSampleBlock();
        $this->createSampleBlock();

        $this->interactor->run(1);
    }

    public function testDelete()
    {
        $this->createSampleArea(1);
        $this->createSampleArea(2);
        $this->assertEquals(2, sizeof($this->repository->findAll()));

        $this->interactor->run(1);

        $this->assertEquals(1, sizeof($this->repository->findAll()));
    }

    private function createSampleArea($areaID)
    {
        $area = new Area();
        $area->setID($areaID);
        $area->setName('Test area');
        $this->repository->createArea($area);
    }

    private function createSampleBlock()
    {
        $block = new Block();
        $block->setName('Block');
        $block->setAreaID(1);
        $this->blockRepository->createBlock($block);
    }
}
 