<?php

namespace CMS\Events;

interface EventManagerInterface
{
    public function fireEvent(EventInterface $event);
    public function addListener($eventName, $listener, $priority = 0);
}
