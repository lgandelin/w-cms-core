<?php

namespace CMS\Events;

use CMS\Entities\Area;
use Symfony\Component\EventDispatcher\Event;

class DeleteAreaEvent extends Event
{
    protected $area;

    public function __construct(Area $area)
    {
        $this->area = $area;
    }

    public function getArea()
    {
        return $this->area;
    }
}
