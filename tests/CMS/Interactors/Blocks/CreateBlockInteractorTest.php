<?php

use CMS\Entities\Block;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\Repositories\InMemory\InMemoryBlockRepository;
use CMS\Structures\BlockStructure;

class CreateBlockInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryBlockRepository();
        $this->interactor = new CreateBlockInteractor($this->repository);
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
        $this->createSampleBlock();

        $this->assertEquals(1, count($this->repository->findAll()));
        $this->assertEquals(1, count($this->repository->findByAreaID(1)));
    }

    private function createSampleBlock()
    {
        $block = new Block();
        $block->setID(1);
        $block->setAreaID(1);
        $block->setName('Test block');
        $this->repository->createBlock($block);
    }


}