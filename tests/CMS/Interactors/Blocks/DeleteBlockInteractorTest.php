<?php

use CMS\Entities\Block;
use CMS\Interactors\Blocks\DeleteBlockInteractor;
use CMS\Repositories\InMemory\InMemoryBlockRepository;

class DeleteBlockInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryBlockRepository();
        $this->interactor = new DeleteBlockInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingBlock()
    {
        $this->interactor->run(1);
    }

    public function testDelete()
    {
        $this->createSampleBlock(1);
        $this->createSampleBlock(2);
        $this->assertEquals(2, sizeof($this->repository->findAll()));

        $this->interactor->run(1);

        $this->assertEquals(1, sizeof($this->repository->findAll()));
    }

    private function createSampleBlock($blockID)
    {
        $block = new Block();
        $block->setID($blockID);
        $block->setName('Block');
        $block->setAreaID(1);
        $this->repository->createBlock($block);
    }
} 