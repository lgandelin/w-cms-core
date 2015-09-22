<?php

namespace Webaccess\WCMSCore\Interactors\BlockTypes;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\BlockType;

class CreateBlockTypeInteractor
{
    public function run(DataStructure $blockTypeStructure)
    {
        $blockType = new BlockType();
        $blockType->setInfos($blockTypeStructure);

        if ($this->anotherBlockTypeExistsWithSameCode($blockType->getCode())) {
            throw new \Exception('There is already a block type with the same code');
        }

        Context::get('block_type_repository')->createBlockType($blockType);
    }

    private function anotherBlockTypeExistsWithSameCode($code)
    {
        return Context::get('block_type_repository')->findByCode($code);
    }
} 