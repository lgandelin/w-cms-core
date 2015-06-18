<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Structures\DataStructure;

class GlobalBlock extends Block
{
    private $blockReferenceID;

    public function setBlockReferenceID($blockReferenceID)
    {
        $this->blockReferenceID = $blockReferenceID;
    }

    public function getBlockReferenceID()
    {
        return $this->blockReferenceID;
    }

    public function updateContent(DataStructure $blockStructure)
    {
        if ($blockStructure->block_reference_id != $this->getBlockReferenceID()) {
            $this->setBlockReferenceID($blockStructure->block_reference_id);
        }
    }
}
