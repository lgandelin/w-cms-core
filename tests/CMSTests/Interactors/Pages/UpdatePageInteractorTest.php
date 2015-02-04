<?php

use CMS\Converters\PageConverter;
use CMS\Entities\Page;
use CMS\Interactors\Areas\CreateAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Areas\GetAreaInteractor;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Interactors\Pages\UpdatePageInteractor;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Interactors\Pages\GetPagesInteractor;
use CMSTests\Repositories\InMemoryAreaRepository;
use CMSTests\Repositories\InMemoryBlockRepository;
use CMSTests\Repositories\InMemoryPageRepository;
use CMS\Structures\AreaStructure;
use CMS\Structures\BlockStructure;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\PageStructure;

class UpdatePageInteractorTest extends PHPUnit_Framework_TestCase
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
        $this->interactor = new UpdatePageInteractor(
            $this->repository,
            new GetAreasInteractor($this->areaRepository),
            new UpdateAreaInteractor(
                $this->areaRepository,
                new GetAreasInteractor($this->areaRepository)
            ),
            new GetBlocksInteractor($this->blockRepository),
            new UpdateBlockInteractor(
                $this->blockRepository,
                new GetBlocksInteractor($this->blockRepository)
            )
        );
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingPage()
    {
        $pageStructure = new PageStructure([
            'ID' => 1,
            'name' => 'Page'
        ]);

        $this->interactor->run(1, $pageStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdatePageWithInvalidURI()
    {
        $pageStructure = new PageStructure([
            'ID' => 1,
            'name' => 'Page',
            'uri' => ''
        ]);

        $this->repository->createPage($pageStructure);

        $this->interactor->run(1, $pageStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdatePageWithAlreadyExistingPageWithSameURI()
    {
        $pageStructure = new PageStructure([
            'ID' => 1,
            'name' => 'Page 1',
            'uri' => '/my-page',
            'identifier' => 'page-1'
        ]);

        $this->repository->createPage($pageStructure);

        $pageStructure2 = new PageStructure([
            'ID' => 2,
            'name' => 'Page 2',
            'uri' => '/page-2',
            'identifier' => 'page-2'
        ]);

        $this->repository->createPage($pageStructure2);

        $pageStructure2Updated = new PageStructure([
           'uri' => '/my-page'
        ]);

        $this->interactor->run(2, $pageStructure2Updated);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdatePageWithAlreadyExistingPageWithSameIdentifier()
    {
        $pageStructure = new PageStructure([
            'ID' => 1,
            'name' => 'Page 1',
            'uri' => '/my-page',
            'identifier' => 'my-page'
        ]);

        $this->repository->createPage($pageStructure);

        $pageStructure2 = new PageStructure([
            'ID' => 2,
            'name' => 'Page 2',
            'uri' => '/page-2',
            'identifier' => 'my-page-2'
        ]);

        $this->repository->createPage($pageStructure2);

        $pageStructure2Updated = new PageStructure([
            'identifier' => 'my-page'
        ]);

        $this->interactor->run(2, $pageStructure2Updated);
    }

    public function testUpdatePage()
    {
        $this->createSamplePage();

        $pageStructureUpdated = new PageStructure([
            'name' => 'Test page updated',
            'uri' => '/test-page',
            'identifier' => 'test-page'
        ]);

        $this->interactor->run(1, $pageStructureUpdated);

        $page = $this->repository->findByID(1);

        $this->assertEquals('Test page updated', $page->getName());
        $this->assertEquals('/test-page', $page->getURI());
        $this->assertEquals('test-page', $page->getIdentifier());
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setID(1);
        $page->setName('Test page');
        $page->setIdentifier('test-page');
        $page->setURI('/test-page');
        $this->repository->createPage($page);
    }

    public function testUpdatePageToMaster()
    {
        $this->createSamplePage();

        $area = new AreaStructure([
            'ID' => 1,
            'page_id' => 1,
            'name' => 'Test area'
        ]);

        $createAreaInteractor = new CreateAreaInteractor($this->areaRepository, new GetPagesInteractor($this->repository), new GetPageInteractor($this->repository));
        $createAreaInteractor->run($area);

        $block = new HTMLBlockStructure([
            'ID' => 1,
            'area_id' => 1,
            'name' => 'Test block'
        ]);

        $createBlockInteractor = new CreateBlockInteractor($this->blockRepository, new GetAreasInteractor($this->areaRepository), new GetAreaInteractor($this->areaRepository));
        $createBlockInteractor->run($block);

        $pageStructure = new PageStructure([
            'is_master' => 1
        ]);
        $this->interactor->run(1, $pageStructure);

        $area = $this->areaRepository->findByID(1);
        $this->assertEquals(1, $area->getIsMaster());

        $block = $this->blockRepository->findByID(1);
        $this->assertEquals(1, $block->getIsMaster());
    }
}
