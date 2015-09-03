<?php

namespace Webaccess\WCMSCoreTests\Events;

use Webaccess\WCMSCore\Events\EventInterface;

class DeleteAreaListenerSpy {

    public function onDeleteArea(EventInterface $event)
    {
        return null;
    }
}