<?php

namespace Webaccess\WCMSCore\Interactors\BlockTypes;

use Webaccess\WCMSCore\Context;

class GetBlockTypeInteractor
{
    public function getBlockTypeByCode($code, $structure = false)
    {
        if (Context::get('block_type_repository')) {
            if (!$blockType = Context::get('block_type_repository')->findByCode($code)) {
                throw new \Exception('The block type was not found : ' . $code);
            }

            return ($structure) ? $blockType->toStructure() : $blockType;
        }

        return false;
    }
} 