<?php

use CMS\Entities\Area;
use CMS\Entities\Block;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMSTests\Repositories\InMemoryAreaRepository;
use CMSTests\Repositories\InMemoryBlockRepository;
use CMS\Structures\BlockStructure;

class GetBlocksInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $areaRepository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryBlockRepository();
        $this->areaRepository = new InMemoryAreaRepository();
        $this->interactor = new GetBlocksInteractor($this->repository, $this->areaRepository);
    }

    public function testGetBlocks()
    {
        $this->createSampleArea();
        $this->createSampleBlock();
        $this->createSampleBlock();

        $blocks = $this->interactor->getAllByAreaID(1);
        $this->assertEquals(2, count($blocks));

        $this->assertInstanceOf('\CMS\Entities\Block', $blocks[0]);
    }

    public function testGetBlocksAsStructures()
    {
        $this->createSampleArea();
        $this->createSampleBlock();
        $this->createSampleBlock();

        $blocks = $this->interactor->getAllByAreaID(1, true);
        $this->assertEquals(2, count($blocks));

        $this->assertInstanceOf('\CMS\Structures\BlockStructure', $blocks[0]);
    }

    private function createSampleArea()
    {
        $area = new Area();
        $area->setID(1);
        $area->setName('Test area');
        $this->areaRepository->createArea($area);
    }

    private function createSampleBlock()
    {
        $block = new Block();
        $block->setName('Block');
        $block->setAreaID(1);
        $this->repository->createBlock($block);
    }
}
