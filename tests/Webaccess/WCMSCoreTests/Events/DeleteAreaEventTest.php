<?php

namespace Webaccess\WCMSCoreTests\Events;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Events\Events;
use Webaccess\WCMSCore\Interactors\Areas\DeleteAreaInteractor;

class DeleteAreaEventTest extends \PHPUnit_Framework_TestCase {

    private $listener;
    private $interactor;
    private $eventManager;

    public function setUp()
    {
        $this->interactor = new DeleteAreaInteractor();
        $this->eventManager = new EventManagerMock();
        $this->listener = $this->getMock('Webaccess\WCMSCoreTests\Events\DeleteAreaListenerSpy');
        $this->eventManager->addListener(Events::DELETE_AREA, array($this->listener, 'onDeleteArea'));
        $this->interactor->setEventManager($this->eventManager);
    }

    public function testDeleteAreaEventDispatched()
    {
        $area = new Area();
        $area->setID(2);
        $area->setName('Area');
        $area->setIsMaster(1);
        Context::get('area_repository')->createArea($area);

        $this->listener->expects($this->once())->method('onDeleteArea');

        $this->interactor->run(1);
    }
}
 