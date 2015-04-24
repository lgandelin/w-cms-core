<?php

namespace CMS\Interactors;

use CMS\Events\EventManagerInterface;

class Interactor
{
    protected $eventManager;

    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }
}
