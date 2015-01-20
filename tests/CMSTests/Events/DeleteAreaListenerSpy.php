<?php

namespace CMSTests\Events;

use CMS\Events\EventInterface;

class DeleteAreaListenerSpy {

    public function onDeleteArea(EventInterface $event)
    {
        return null;
    }
}