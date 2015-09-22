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
        $blockTypeStructures = [];
        if (is_array($blockTypes) && sizeof($blockTypes) > 0) {
            foreach ($blockTypes as $blockType) {
                $blockTypeStructures[] = $blockType->toStructure();
            }
        }

        return $blockTypeStructures;
    }
} 