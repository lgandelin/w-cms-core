<?php

namespace Webaccess\WCMSCore\Events;

use Webaccess\WCMSCore\Entities\Area;

class DeleteAreaEvent implements EventInterface
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

    public function getName()
    {
        return Events::DELETE_AREA;
    }
}
