<?php

use CMS\Entities\Area;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Interactors\Areas\GetAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\Interactors\Blocks\DuplicateBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Structures\BlockStructure;
use CMSTests\Repositories\InMemoryAreaRepository;
use CMSTests\Repositories\InMemoryBlockRepository;

class DuplicateBlockInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $areaRepository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryBlockRepository();
        $this->areaRepository = new InMemoryAreaRepository();
        $this->interactor = new DuplicateBlockInteractor(
            new CreateBlockInteractor($this->repository, new GetAreasInteractor($this->areaRepository), new GetAreaInteractor($this->areaRepository)),
            new UpdateBlockInteractor($this->repository, new GetBlocksInteractor($this->repository))
        );
    }

    public function testDuplicateHTMLBlock()
    {
        $area = new Area();
        $area->setID(1);
        $this->areaRepository->createArea($area);

        $block = new HTMLBlock();
        $block->setID(1);
        $block->setName('HTML Block');
        $block->setHTML('<h1>Hello World</h1>');
        $this->repository->createBlock($block);

        $this->interactor->run(BlockStructure::toStructure($block), 1);

        $duplicatedBlock = $this->repository->findByID(2);

        $this->assertEquals(1, count($duplicatedBlock));
        $this->assertEquals('<h1>Hello World</h1>', $duplicatedBlock->getHTML());
    }
}