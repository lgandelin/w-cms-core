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
        $blockID = $this->createSampleBlock();
        $this->assertEquals(1, sizeof($this->repository->findAll()));

        $this->interactor->run($blockID);

        $this->assertEquals(0, sizeof($this->repository->findAll()));
    }

    private function createSampleBlock()
    {
        $block = new Block();
        $block->setName('Block');

        return $this->repository->createBlock($block);
    }
} 