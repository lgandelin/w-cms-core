<?php

use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Repositories\InMemory\InMemoryAreaRepository;
use CMS\Repositories\InMemory\InMemoryBlockRepository;
use CMS\Structures\AreaStructure;
use CMS\Structures\BlockStructure;

class GetAllBlocksInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->repository = new InMemoryBlockRepository();
        $this->areaRepository = new InMemoryAreaRepository();
        $this->interactor = new GetBlocksInteractor($this->repository, $this->areaRepository);
    }

    /**
     * @expectedException Exception
     */
    public function testGetAllBlocksOfNonExistingArea()
    {
        $this->interactor->getAll(1);
    }

    public function testGetAllBlocks()
    {
        $areaStructure = new AreaStructure([
            'ID' => 1,
            'name' => 'Area 1',
            'page_id' => 1
        ]);

        $this->areaRepository->createArea($areaStructure);

        $block1 = new BlockStructure([
            'ID' => 1,
            'name' => 'Block 1',
            'area_id' => 1
        ]);

        $block2 = new BlockStructure([
            'ID' => 2,
            'name' => 'Block 2',
            'area_id' => 1
        ]);

        $this->repository->createBlock($block1);
        $this->repository->createBlock($block2);

        $blocks = $this->interactor->getAll(1);

        $this->assertEquals(2, count($blocks));
    }

    public function testGetAllBlocksWithContent()
    {
        $areaStructure = new AreaStructure([
            'ID' => 1,
            'name' => 'Area 1',
            'page_id' => 1
        ]);

        $this->areaRepository->createArea($areaStructure);

        $block1 = new BlockStructure([
            'ID' => 1,
            'name' => 'Block 1',
            'type' => 'html',
            'html' => '<h1>Hello</h1>',
            'area_id' => 1
        ]);

        $block2 = new BlockStructure([
            'ID' => 2,
            'name' => 'Block 2',
            'area_id' => 1
        ]);

        $this->repository->createBlock($block1);
        $this->repository->createBlock($block2);

        $blocks = $this->interactor->getAll(1);

        $this->assertEquals('<h1>Hello</h1>', $blocks[0]->getHTML());
    }
}
 