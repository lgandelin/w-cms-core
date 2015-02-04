<?php

namespace CMS\Interactors\Blocks;

use CMS\Structures\BlockStructure;

class DuplicateBlockInteractor
{
    private $createBlockInteractor;
    private $updateBlockInteractor;

    public function __construct(CreateBlockInteractor $createBlockInteractor, UpdateBlockInteractor $updateBlockInteractor)
    {
        $this->createBlockInteractor = $createBlockInteractor;
        $this->updateBlockInteractor = $updateBlockInteractor;
    }

    public function run(BlockStructure $blockStructure, $newAreaID)
    {
        $blockStructure->ID = null;
        $blockStructure->area_id = $newAreaID;

        $blockID = $this->createBlockInteractor->run($blockStructure);
        $this->updateBlockInteractor->run($blockID, $blockStructure);

        return $blockID;
    }
} 