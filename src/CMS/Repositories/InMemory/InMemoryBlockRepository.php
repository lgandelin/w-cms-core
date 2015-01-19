<?php

namespace CMS\Repositories\InMemory;

use CMS\Entities\Block;
use CMS\Entities\Blocks\ArticleBlock;
use CMS\Repositories\BlockRepositoryInterface;

class InMemoryBlockRepository implements BlockRepositoryInterface
{
    private $blocks;

    public function __construct()
    {
        $this->blocks = [];
    }

    public function findByID($blockID)
    {
        foreach ($this->blocks as $block) {
            if ($block->getID() == $blockID) {
                return $block;
            }
        }

        return false;
    }

    public function findAll()
    {
        return $this->blocks;
    }

    public function findByAreaID($areaID)
    {
        $blocks = array();
        foreach ($this->blocks as $block) {
            if ($block->getAreaID() == $areaID) {
                $blocks[]= $block;
            }
        }

        return $blocks;
    }

    public function createBlock(Block $block)
    {
        $blockID = sizeof($this->blocks) + 1;
        $block->setID($blockID);
        $this->blocks[]= $block;

        return $blockID;
    }

    public function updateBlock(Block $block)
    {
        foreach ($this->blocks as $blockModel) {
            if ($blockModel->getID() == $block->getID()) {
                $blockModel->setName($block->getName());
                $blockModel->setWidth($block->getWidth());
                $blockModel->setHeight($block->getHeight());
                $blockModel->setClass($block->getClass());
                $blockModel->setOrder($block->getOrder());
                $blockModel->setDisplay($block->getDisplay());
                $blockModel->setType($block->getType());
                $blockModel->setIsMaster($block->getIsMaster());

                if ($block instanceof ArticleBlock) {
                    $blockModel->setArticleID($block->getArticleID());
                }
            }
        }
    }

    public function updateBlockType(Block $block)
    {
        foreach ($this->blocks as $blockModel) {
            if ($blockModel->getID() == $block->getID()) {
                $blockModel->setType($block->getType());
            }
        }
    }

    public function deleteBlock($blockID)
    {
        foreach ($this->blocks as $i => $block) {
            if ($block->getID() == $blockID) {
                unset($this->blocks[$i]);
            }
        }
    }

    public function findGlobalBlocks()
    {
        $blocks = array();
        foreach ($this->blocks as $block) {
            if ($block->getIsGlobal())
                $blocks[]= $block;
        }

        return $blocks;
    }

    public function findChildBlocks($blockID)
    {
        $blocks = array();
        foreach ($this->blocks as $block) {
            if ($block->getMasterBlockID() == $blockID)
                $blocks[]= $block;
        }

        return $blocks;
    }
}
