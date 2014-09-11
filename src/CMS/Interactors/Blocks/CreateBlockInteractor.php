<?php

namespace CMS\Interactors\Blocks;

use CMS\Entities\Block;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Repositories\BlockRepositoryInterface;
use CMS\Structures\BlockStructure;

class CreateBlockInteractor
{
    protected $repository;

    public function __construct(BlockRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(BlockStructure $blockStructure)
    {
        if ($blockStructure->type == 'html') {
            $block = new HTMLBlock();
            if ($blockStructure->html !== null && $blockStructure->html != $block->getHTML()) $block->setHTML($blockStructure->html);
        } else
            $block = new Block();

        if ($blockStructure->name !== null) $block->setName($blockStructure->name);
        if ($blockStructure->width !== null) $block->setWidth($blockStructure->width);
        if ($blockStructure->height !== null) $block->setHeight($blockStructure->height);
        if ($blockStructure->type !== null) $block->setType($blockStructure->type);
        if ($blockStructure->class !== null) $block->setClass($blockStructure->class);
        if ($blockStructure->area_id !== null) $block->setAreaID($blockStructure->area_id);

        if ($block->valid()) {
            return $this->repository->createBlock($block);
        }
    }
}