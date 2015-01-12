<?php

use CMS\Entities\Block;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Repositories\InMemory\InMemoryBlockRepository;
use CMS\Structures\BlockStructure;

class UpdateBlockInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryBlockRepository();
        $this->interactor = new UpdateBlockInteractor($this->repository, new GetBlocksInteractor($this->repository));
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingBlock()
    {
        $blockStructure = new BlockStructure([
            'name' => 'Block'
        ]);

        $this->interactor->run(1, $blockStructure);
    }

    public function testUpdate()
    {
        $blockID = $this->createSampleBlock();

        $blockStructure = new BlockStructure([
            'name' => 'Block test updated'
        ]);

        $this->interactor->run($blockID, $blockStructure);

        $block = $this->repository->findByID($blockID);
        $this->assertEquals('Block test updated', $block->getName());
    }

    public function testUpdateBlockType()
    {
        $blockID = $this->createSampleBlock();

        $blockStructure = new BlockStructure([
            'type' => 'menu',
            'menu_id' => 1
        ]);

        $this->interactor->run($blockID, $blockStructure);

        $block = $this->repository->findByID($blockID);
        $this->assertEquals('menu', $block->getType());
    }

    private function createSampleBlock()
    {
        $block = new Block();
        $block->setName('Block');
        $block->setType('html');
        $block->setAreaID(null);

        return $this->repository->createBlock($block);
    }

    public function testUpdateMasterBlock()
    {
        $masterBlock = new Block();
        $masterBlock->setID(1);
        $masterBlock->setIsMaster(true);
        $masterBlock->setName('Test block');
        $masterBlock->setAreaID(null);
        $this->repository->createBlock($masterBlock);

        $childBlock1 = new Block();
        $childBlock1->setID(2);
        $childBlock1->setMasterBlockID($masterBlock->getID());
        $childBlock1->setName('Test block');
        $childBlock1->setAreaID(null);
        $this->repository->createBlock($childBlock1);

        $childBlock2 = new Block();
        $childBlock2->setID(3);
        $childBlock2->setMasterBlockID($masterBlock->getID());
        $childBlock2->setName('Test block');
        $childBlock2->setAreaID(null);
        $this->repository->createBlock($childBlock2);

        $blockStructure = new BlockStructure([
            'name' => 'Test block updated'
        ]);
        $this->interactor->run($masterBlock->getID(), $blockStructure);

        $childBlock1 = $this->repository->findByID($childBlock1->getID());
        $childBlock2 = $this->repository->findByID($childBlock2->getID());

        $this->assertEquals('Test block updated', $childBlock1->getName());
        $this->assertEquals('Test block updated', $childBlock2->getName());
    }
}
