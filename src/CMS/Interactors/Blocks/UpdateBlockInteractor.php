<?php

namespace CMS\Interactors\Blocks;

use CMS\Repositories\BlockRepositoryInterface;
use CMS\Structures\BlockStructure;
use CMS\Structures\Blocks\MenuBlockStructure;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\Blocks\ViewFileBlockStructure;

class UpdateBlockInteractor {

    private $repository;

    public function __construct(BlockRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run($blockID, BlockStructure $blockStructure)
    {
        if ($block = $this->getByID($blockID)) {
            if ($blockStructure->type !== null && $blockStructure->type != $block->getType()) $block->setType($blockStructure->type);
            $this->repository->updateBlockType($block);
        }

        if ($block = $this->getByID($blockID)) {
            if ($blockStructure->name !== null && $blockStructure->name != $block->getName()) $block->setName($blockStructure->name);
            if ($blockStructure->width !== null && $blockStructure->width != $block->getWidth()) $block->setWidth($blockStructure->width);
            if ($blockStructure->height !== null && $blockStructure->height != $block->getHeight()) $block->setHeight($blockStructure->height);
            if ($blockStructure->class !== null && $blockStructure->class != $block->getClass()) $block->setClass($blockStructure->class);
            if ($blockStructure->order !== null && $blockStructure->order != $block->getOrder()) $block->setOrder($blockStructure->order);
            if ($blockStructure->area_id !== null && $blockStructure->area_id != $block->getAreaId()) $block->setAreaID($blockStructure->area_id);
            if ($blockStructure->display !== null && $blockStructure->display != $block->getDisplay()) $block->setDisplay($blockStructure->display);

            if ($blockStructure instanceof HTMLBlockStructure && $block->getType() == 'html' && $blockStructure->html !== null && $blockStructure->html != $block->getHTML())
                $block->setHTML($blockStructure->html);

            if ($blockStructure instanceof MenuBlockStructure && $block->getType() == 'menu' && $blockStructure->menu_id !== null && $blockStructure->menu_id != $block->getMenuID())
                $block->setMenuID($blockStructure->menu_id);

            if ($blockStructure instanceof ViewFileBlockStructure && $block->getType() == 'view_file' && $blockStructure->view_file !== null && $blockStructure->view_file != $block->getViewFile())
                $block->setViewFile($blockStructure->view_file);
        }

        $this->repository->updateBlock($block);
    }

    public function getByID($blockID)
    {
        if (!$block = $this->repository->findByID($blockID))
            throw new \Exception('The block was not found');

        return $block;
    }
} 