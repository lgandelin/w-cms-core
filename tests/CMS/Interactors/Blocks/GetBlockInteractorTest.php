<?php

use CMS\Entities\Area;
use CMS\Entities\Block;
use CMS\Interactors\Blocks\GetBlockInteractor;
use CMS\Repositories\InMemory\InMemoryBlockRepository;
use CMS\Structures\BlockStructure;

class GetBlockInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryBlockRepository();
        $this->interactor = new GetBlockInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingBlock()
    {
        $this->interactor->getBlockByID(1);
    }

    public function testGetBlock()
    {
        $blockID = $this->createSampleBlock();

        $this->assertInstanceOf('\CMS\Entities\Block', $this->interactor->getBlockByID($blockID));
    }

    public function testGetBlockAsStructure()
    {
        $blockID = $this->createSampleBlock();

        $this->assertInstanceOf('\CMS\Structures\BlockStructure', $this->interactor->getBlockByID($blockID, true));
    }

    private function createSampleBlock()
    {
        $block = new Block();

        return $this->repository->createBlock($block);
    }
}
