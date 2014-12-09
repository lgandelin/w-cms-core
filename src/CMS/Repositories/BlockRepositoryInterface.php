<?php

namespace CMS\Repositories;

use CMS\Entities\Block;

interface BlockRepositoryInterface
{
    public function findByID($blockID);

    public function findByAreaID($areaID);

    public function findGlobalBlocks();

    public function findAll();

    public function createBlock(Block $block);

    public function updateBlock(Block $block);

    public function deleteBlock($blockID);
}
