<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Structures\Blocks\GlobalBlockStructure;

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

    public function getStructure()
    {
        $blockStructure = new GlobalBlockStructure();
        $blockStructure->block_reference_id = $this->getBlockReferenceID();

        return $blockStructure;
    }

    public function updateContent(GlobalBlockStructure $blockStructure)
    {
        if ($blockStructure->block_reference_id != $this->getBlockReferenceID()) {
            $this->setBlockReferenceID($blockStructure->block_reference_id);
        }
    }
}
