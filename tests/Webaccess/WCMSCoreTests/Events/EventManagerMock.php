<?php

namespace Webaccess\WCMSCoreTests\Events;

use Webaccess\WCMSCore\Events\EventInterface;
use Webaccess\WCMSCore\Events\EventManagerInterface;

class EventManagerMock implements EventManagerInterface {

    public function fireEvent(EventInterface $event)
    {
        $callable = $this->events[$event->getName()];

        return call_user_func_array(array($callable['object'], $callable['method']), array($event));
    }

    public function addListener($eventName, $listener, $priority = 0)
    {
        $this->events[$eventName] = array(
            'object' => $listener[0],
            'method' => $listener[1]
        );
    }
}