<?php

use CMS\Entities\Area;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Entities\Page;
use CMS\Interactors\Areas\DeleteAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Articles\GetArticlesInteractor;
use CMS\Interactors\Articles\UpdateArticleInteractor;
use CMS\Interactors\Blocks\DeleteBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Pages\DeletePageInteractor;
use CMSTests\Repositories\InMemoryAreaRepository;
use CMSTests\Repositories\InMemoryArticleRepository;
use CMSTests\Repositories\InMemoryBlockRepository;
use CMSTests\Repositories\InMemoryPageRepository;

class DeletePageInteractorTest extends PHPUnit_Framework_TestCase
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
        $this->articleRepository = new InMemoryArticleRepository();
        $this->interactor = new DeletePageInteractor(
            $this->repository,
            new GetAreasInteractor($this->areaRepository),
            new DeleteAreaInteractor(
                $this->areaRepository,
                new GetAreasInteractor($this->areaRepository),
                new GetBlocksInteractor($this->blockRepository),
                new DeleteBlockInteractor(
                    $this->blockRepository,
                    new GetBlocksInteractor($this->blockRepository)
                )
            ),
            new GetArticlesInteractor($this->articleRepository),
            new UpdateArticleInteractor($this->articleRepository)
        );
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingPage()
    {
        $this->interactor->run(2);
    }

    public function testDelete()
    {
        $pageID = $this->createSamplePage();
        $this->assertCount(1, $this->repository->findAll());

        $this->interactor->run($pageID);
        $this->assertCount(0, $this->repository->findAll());
    }

    public function testDeleteAlongWithAreasAndBlocks()
    {
        $pageID = $this->createSamplePage();
        $areaID = $this->createSampleArea($pageID);
        $this->createSampleBlock($areaID);
        $this->createSampleBlock($areaID);
        $this->createSampleBlock($areaID);

        $this->assertCount(1, $this->repository->findAll());
        $this->assertCount(1, $this->areaRepository->findAll($pageID));
        $this->assertCount(3, $this->blockRepository->findAll($areaID));

        $this->interactor->run($pageID);

        $this->assertCount(0, $this->repository->findAll());
        $this->assertCount(0, $this->areaRepository->findAll());
        $this->assertCount(0, $this->blockRepository->findAll());
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setName('Test page');
        $page->setIdentifier('test-page');
        $page->setURI('/test-page');

        return $this->repository->createPage($page);
    }

    private function createSampleArea($pageID)
    {
        $area = new Area();
        $area->setPageID($pageID);
        $area->setName('Test area');

        return $this->areaRepository->createArea($area);
    }

    private function createSampleBlock($areaID)
    {
        $block = new HTMLBlock();
        $block->setName('Test block');
        $block->setAreaID($areaID);
        $block->setType('html');

        return $this->blockRepository->createBlock($block);
    }
}
