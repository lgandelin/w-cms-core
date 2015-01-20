<?php

use CMS\Entities\Area;
use CMS\Entities\Block;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Entities\Page;
use CMS\Interactors\Areas\CreateAreaInteractor;
use CMS\Interactors\Areas\DuplicateAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Areas\GetAreaInteractor;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Interactors\Blocks\DuplicateBlockInteractor;
use CMS\Interactors\Pages\CreatePageInteractor;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Interactors\Pages\GetPagesInteractor;
use CMS\Interactors\Pages\DuplicatePageInteractor;
use CMSTests\Repositories\InMemoryAreaRepository;
use CMSTests\Repositories\InMemoryBlockRepository;
use CMSTests\Repositories\InMemoryPageRepository;

class DuplicatePageInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $areaRepository;
    private $blockRepository;
    private $interactor;
    
    public function setUp()
    {
        $this->repository = new InMemoryPageRepository();
        $this->areaRepository = new InMemoryAreaRepository();
        $this->blockRepository = new InMemoryBlockRepository();
        $this->interactor = new DuplicatePageInteractor(
            $this->repository,
            new GetAreasInteractor($this->areaRepository),
            new GetBlocksInteractor($this->blockRepository),
            new CreatePageInteractor($this->repository),
            new DuplicateAreaInteractor(
                new CreateAreaInteractor(
                    $this->areaRepository,
                    new GetPagesInteractor($this->repository),
                    new GetPageInteractor($this->repository)
                )
            ),
            new DuplicateBlockInteractor(
                new CreateBlockInteractor($this->blockRepository, new GetAreasInteractor($this->areaRepository), new GetAreaInteractor($this->areaRepository)),
                new UpdateBlockInteractor($this->blockRepository, new GetBlocksInteractor($this->blockRepository)
                )
            )
        );
    }

    /**
     * @expectedException Exception
     */
    public function testDuplicateNonExistingPage()
    {
        $this->interactor->run(2);
    }

    public function testDuplicatePage()
    {
        $this->createSamplePage(1);
        $this->createSampleArea(1, 1);
        $this->createSampleArea(2, 1);
        $this->createSampleBlock(1, 1);
        $this->createSampleBlock(2, 1);
        $this->createSampleBlock(3, 1);
        $this->createSampleBlock(4, 2);

        $this->assertCount(1, $this->repository->findAll());

        $this->interactor->run(1);

        $this->assertCount(2, $this->repository->findAll());
        $pageDuplicated = $this->repository->findByIdentifier('test-page-copy');

        $this->assertEquals($pageDuplicated->getName(), 'Test page - COPY');
        $this->assertEquals($pageDuplicated->getURI(), '/test-page-copy');
        $this->assertEquals($pageDuplicated->getIdentifier(), 'test-page-copy');

        $this->assertEquals(2, count($this->areaRepository->findByPageID(1)));
        $this->assertEquals(3, count($this->blockRepository->findByAreaID(1)));
    }

    private function createSamplePage($pageID)
    {
        $page = new Page();
        $page->setID($pageID);
        $page->setName('Test page');
        $page->setIdentifier('test-page');
        $page->setURI('/test-page');
        $this->repository->createPage($page);
    }

    private function createSampleArea($areaID, $pageID)
    {
        $area = new Area();
        $area->setID($areaID);
        $area->setPageID($pageID);
        $area->setName('Test area ' . $areaID);

        $this->areaRepository->createArea($area);
    }

    private function createSampleBlock($blockID, $areaID)
    {
        $block = new HTMLBlock();
        $block->setID($blockID);
        $block->setName('Test block ' . $blockID);
        $block->setAreaID($areaID);
        $block->setType('html');

        $this->blockRepository->createBlock($block);
    }
}
