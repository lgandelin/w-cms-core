<?php

namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\Block;

interface BlockRepositoryInterface
{
    public function findByID($blockID);

    public function findByAreaID($areaID);

    public function findByAreaIDAndVersionNumber($areaID, $versionNumber);

    public function findGlobalBlocks();

    public function findChildBlocks($blockID);

    public function findAll();

    public function createBlock(Block $block);

    public function updateBlock(Block $block);

    public function duplicateBlock(Block $block);

    public function deleteBlock($blockID);
}
