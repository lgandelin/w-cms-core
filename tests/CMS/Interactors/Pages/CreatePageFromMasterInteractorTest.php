<?php

use CMS\Interactors\Areas\CreateAreaInteractor;
use CMS\Interactors\Areas\DuplicateAreaInteractor;
use CMS\Interactors\Areas\GetAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\Interactors\Blocks\DuplicateBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Interactors\Pages\CreatePageFromMasterInteractor;
use CMS\Interactors\Pages\CreatePageInteractor;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Interactors\Pages\GetPagesInteractor;
use CMS\Repositories\InMemory\InMemoryAreaRepository;
use CMS\Repositories\InMemory\InMemoryBlockRepository;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\AreaStructure;
use CMS\Structures\BlockStructure;
use CMS\Structures\PageStructure;

class CreatePageFromMasterInteractorTest extends PHPUnit_Framework_TestCase {

    private $interactor;
    private $repository;

    public function __construct()
    {
        $this->repository = new InMemoryPageRepository();
        $this->areaRepository = new InMemoryAreaRepository();
        $this->blockRepository = new InMemoryBlockRepository();
        $this->interactor = new CreatePageFromMasterInteractor(
            $this->repository,
            new CreatePageInteractor($this->repository),
            new GetAreasInteractor($this->areaRepository),
            new UpdateAreaInteractor(
                $this->areaRepository,
                new GetAreasInteractor($this->areaRepository)
            ),
            new DuplicateAreaInteractor(new CreateAreaInteractor($this->areaRepository, new GetPagesInteractor($this->repository), new GetPageInteractor($this->repository))),
            new GetBlocksInteractor($this->blockRepository),
            new UpdateBlockInteractor(
                $this->blockRepository,
                new GetBlocksInteractor($this->blockRepository)
            ),
            new DuplicateBlockInteractor(
                new CreateBlockInteractor(
                    $this->blockRepository,
                    new GetAreasInteractor($this->areaRepository),
                    new GetAreaInteractor($this->areaRepository)
                ),
                new UpdateBlockInteractor(
                    $this->blockRepository,
                    new GetBlocksInteractor($this->blockRepository)
                )
            )
        );
    }

    public function testCreatePageFromMasterPage()
    {
        //Create master page
        $pageStructure = new PageStructure([
            'ID' => 1,
            'uri' => '/master',
            'identifier' => 'master',
            'name' => 'Master page',
            'is_master' => 1
        ]);

        $this->interactor->run($pageStructure);

        $area = new AreaStructure([
            'ID' => 1,
            'page_id' => 1,
            'name' => 'Test area'
        ]);

        $createAreaInteractor = new CreateAreaInteractor($this->areaRepository, new GetPagesInteractor($this->repository), new GetPageInteractor($this->repository));
        $createAreaInteractor->run($area);

        $block = new BlockStructure([
            'ID' => 1,
            'area_id' => 1,
            'name' => 'Test block',
        ]);

        $createBlockInteractor = new CreateBlockInteractor($this->blockRepository, new GetAreasInteractor($this->areaRepository), new GetAreaInteractor($this->areaRepository));
        $createBlockInteractor->run($block);

        //Create child page
        $pageStructureChild = new PageStructure([
            'ID' => 2,
            'uri' => '/child',
            'identifier' => 'child',
            'name' => 'Child page',
            'master_page_id' => 1
        ]);

        $this->interactor->run($pageStructureChild);

        $areas = $this->areaRepository->findByPageID(2);
        $this->assertEquals(1, $areas[0]->getMasterAreaID());

        $blocks = $this->blockRepository->findByAreaID(2);
        $this->assertEquals(1, $blocks[0]->getMasterBlockID());
    }
}