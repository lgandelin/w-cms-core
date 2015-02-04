<?php

use CMS\Entities\Blocks\HTMLBlock;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMSTests\Repositories\InMemoryBlockRepository;
use CMS\Structures\Blocks\HTMLBlockStructure;
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
        $blockStructure = new HTMLBlockStructure([
            'name' => 'Block'
        ]);

        $this->interactor->run(1, $blockStructure);
    }

    public function testUpdate()
    {
        $blockID = $this->createSampleBlock();

        $blockStructure = new HTMLBlockStructure([
            'name' => 'Block test updated'
        ]);

        $this->interactor->run($blockID, $blockStructure);

        $block = $this->repository->findByID($blockID);
        $this->assertEquals('Block test updated', $block->getName());
    }

    private function createSampleBlock()
    {
        $block = new HTMLBlock();
        $block->setName('Block');
        $block->setType('html');
        $block->setAreaID(null);

        return $this->repository->createBlock($block);
    }

    public function testUpdateMasterBlock()
    {
        $masterBlock = new HTMLBlock();
        $masterBlock->setID(1);
        $masterBlock->setIsMaster(true);
        $masterBlock->setName('Test block');
        $masterBlock->setAreaID(null);
        $this->repository->createBlock($masterBlock);

        $childBlock1 = new HTMLBlock();
        $childBlock1->setID(2);
        $childBlock1->setMasterBlockID($masterBlock->getID());
        $childBlock1->setName('Test block');
        $childBlock1->setAreaID(null);
        $this->repository->createBlock($childBlock1);

        $childBlock2 = new HTMLBlock();
        $childBlock2->setID(3);
        $childBlock2->setMasterBlockID($masterBlock->getID());
        $childBlock2->setName('Test block');
        $childBlock2->setAreaID(null);
        $this->repository->createBlock($childBlock2);

        $blockStructure = new HTMLBlockStructure([
            'name' => 'Test block updated'
        ]);
        $this->interactor->run($masterBlock->getID(), $blockStructure);

        $childBlock1 = $this->repository->findByID($childBlock1->getID());
        $childBlock2 = $this->repository->findByID($childBlock2->getID());

        $this->assertEquals('Test block updated', $childBlock1->getName());
        $this->assertEquals('Test block updated', $childBlock2->getName());
    }

    public function testUpdateHTMLBlock()
    {
        $block = new HTMLBlock();
        $block->setID(1);
        $block->setHTML('<h1>Hello World</h1>');
        $this->repository->createBlock($block);

        $blockStructure = new HTMLBlockStructure([
           'html' => '<h1>Goodbye World</h1>'
        ]);
        $this->interactor->run(1, $blockStructure);

        $blockUpdated = $this->repository->findByID(1);
        $this->assertEquals('<h1>Goodbye World</h1>', $blockUpdated->getHTML());
    }
}
