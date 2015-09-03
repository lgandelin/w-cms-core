<?php

namespace Webaccess\WCMSCore\Interactors;

use Webaccess\WCMSCore\Events\EventManagerInterface;

class Interactor
{
    protected $eventManager;

    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }
}
