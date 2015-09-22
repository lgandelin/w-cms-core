<?php

namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\BlockType;

interface BlockTypeRepositoryInterface
{
    public function findAll();

    public function findByCode($code);

    public function createBlockType(BlockType $blockType);
} 