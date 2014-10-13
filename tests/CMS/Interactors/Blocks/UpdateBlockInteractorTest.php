<?php

use CMS\Entities\Block;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Repositories\InMemory\InMemoryBlockRepository;
use CMS\Structures\BlockStructure;

class UpdateBlockInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryBlockRepository();
        $this->interactor = new UpdateBlockInteractor($this->repository);
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
        $this->createSampleBlock();

        $blockStructure = new BlockStructure([
            'name' => 'Block test updated'
        ]);

        $this->interactor->run(1, $blockStructure);

        $block = $this->repository->findByID(1);
        $this->assertEquals('Block test updated', $block->getName());
    }

    public function testUpdateBlockType()
    {
        $this->createSampleBlock();

        $blockStructure = new BlockStructure([
            'type' => 'menu',
            'menu_id' => 1
        ]);

        $this->interactor->run(1, $blockStructure);

        $block = $this->repository->findByID(1);
        $this->assertEquals('menu', $block->getType());
    }

    private function createSampleBlock()
    {
        $block = new Block();
        $block->setID(1);
        $block->setName('Block');
        $block->setType('html');
        $block->setAreaID(1);
        $this->repository->createBlock($block);
    }
}
 