<?php

namespace Webaccess\WCMSCore\Events;

interface EventManagerInterface
{
    public function fireEvent(EventInterface $event);
    public function addListener($eventName, $listener, $priority = 0);
}
