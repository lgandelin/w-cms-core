<?php

namespace Webaccess\WCMSCore\Interactors\BlockTypes;

use Webaccess\WCMSCore\Context;

class GetBlockTypesInteractor
{
    public function getAll($structure = false)
    {
        $blockTypes = Context::get('block_type_repository')->findAll();

        return ($structure) ? $this->getBlockTypeStructures($blockTypes) : $blockTypes;
    }

    private function getBlockTypeStructures($blockTypes)
    {
        return array_map(function($blockType) {
            return $blockType->toStructure();
        }, $blockTypes);
    }
} 