<?php

namespace CMS\Repositories;

use CMS\Entities\Area;

interface AreaRepositoryInterface
{
    public function findByID($areaID);

    public function findByPageID($pageID);

    public function findAll();

    public function createArea(Area $area);

    public function updateArea(Area $area);

    public function deleteArea($areaID);
}
