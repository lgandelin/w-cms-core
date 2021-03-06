<?php

namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\Area;

interface AreaRepositoryInterface
{
    public function findByID($areaID);

    public function findByPageID($pageID);

    public function findAll();

    public function findChildAreas($areaID);

    public function createArea(Area $area);

    public function updateArea(Area $area);

    public function deleteArea($areaID);
}
