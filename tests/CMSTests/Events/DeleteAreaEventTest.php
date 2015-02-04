<?php

namespace CMSTests\Events;

use CMS\Entities\Area;
use CMS\Events\Events;
use CMS\Interactors\Areas\DeleteAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Blocks\DeleteBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMSTests\Repositories\InMemoryAreaRepository;
use CMSTests\Repositories\InMemoryBlockRepository;

class DeleteAreaEventTest extends \PHPUnit_Framework_TestCase {

    private $listener;
    private $interactor;
    private $repository;
    private $blockRepository;

    public function setUp()
    {
        $this->repository = new InMemoryAreaRepository();
        $this->blockRepository = new InMemoryBlockRepository();

        $this->interactor = new DeleteAreaInteractor(
            $this->repository,
            new GetAreasInteractor($this->repository),
            new GetBlocksInteractor($this->blockRepository),
            new DeleteBlockInteractor($this->blockRepository, new GetBlocksInteractor($this->blockRepository))
        );

        $this->eventManager = new EventManagerMock();
        $this->listener = $this->getMock('CMSTests\Events\DeleteAreaListenerSpy');
        $this->eventManager->addListener(Events::DELETE_AREA, array($this->listener, 'onDeleteArea'));
        $this->interactor->setEventManager($this->eventManager);
    }

    public function testDeleteAreaEventDispatched()
    {
        $area = new Area();
        $area->setID(2);
        $area->setName('Area');
        $area->setIsMaster(1);
        $this->repository->createArea($area);

        $this->listener->expects($this->once())->method('onDeleteArea');

        $this->interactor->run(1);
    }
}
 