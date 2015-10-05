<?php

namespace Webaccess\WCMSCore\Interactors\BlockTypes;

use Webaccess\WCMSCore\Context;

class DeleteBlockTypeInteractor extends GetBlockTypeInteractor
{
    public function run($blockTypeCode)
    {
        if (!$blockType = $this->getBlockTypeByCode($blockTypeCode)) {
            throw new \Exception('The block type was not found : ' . $blockTypeCode);
        }

        Context::get('block_type_repository')->deleteBlockType($blockType->getID());
    }
} 