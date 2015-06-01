<?php

namespace CMSTests\Events;

use CMS\Context;
use CMS\Entities\Area;
use CMS\Events\Events;
use CMS\Interactors\Areas\DeleteAreaInteractor;

class DeleteAreaEventTest extends \PHPUnit_Framework_TestCase {

    private $listener;
    private $interactor;
    private $eventManager;

    public function setUp()
    {
        $this->interactor = new DeleteAreaInteractor();
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
        Context::$areaRepository->createArea($area);

        $this->listener->expects($this->once())->method('onDeleteArea');

        $this->interactor->run(1);
    }
}
 