<?php

use CMS\Entities\Block;
use CMS\Interactors\Blocks\DeleteBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMSTests\Repositories\InMemoryBlockRepository;

class DeleteBlockInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryBlockRepository();
        $this->interactor = new DeleteBlockInteractor($this->repository, new GetBlocksInteractor($this->repository));
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

    public function testDeleteMasterBlock()
    {
        $block = new Block();
        $block->setID(2);
        $block->setName('Block');
        $block->setIsMaster(1);
        $this->repository->createBlock($block);

        $childBlock = new Block();
        $childBlock->setID(2);
        $childBlock->setName('Child block');
        $childBlock->setMasterBlockID(1);
        $this->repository->createBlock($childBlock);

        $this->interactor->run(1);

        $this->assertFalse($this->repository->findByID(2));
    }
}
