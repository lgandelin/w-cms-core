<?php

namespace CMS\Interactors\Blocks;

use CMS\Structures\Blocks\ArticleBlockStructure;
use CMS\Structures\Blocks\ArticleListBlockStructure;
use CMS\Structures\Blocks\GlobalBlockStructure;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\Blocks\MenuBlockStructure;
use CMS\Structures\Blocks\ViewFileBlockStructure;
use CMS\Structures\BlockStructure;

class DuplicateBlockInteractor
{
    private $createBlockInteractor;
    private $updateBlockInteractor;

    public function __construct(CreateBlockInteractor $createBlockInteractor, UpdateBlockInteractor $updateBlockInteractor)
    {
        $this->createBlockInteractor = $createBlockInteractor;
        $this->updateBlockInteractor = $updateBlockInteractor;
    }

    public function run(BlockStructure $blockStructure, $newAreaID)
    {
        $blockStructure->ID = null;
        $blockStructure->area_id = $newAreaID;

        $blockID = $this->createBlockInteractor->run($blockStructure);
        $blockStructureContent = new BlockStructure();

        if ($blockStructure instanceof HTMLBlockStructure && $blockStructure->type == 'html') {
            $blockStructureContent = new HTMLBlockStructure([
                'html' => $blockStructure->html
            ]);
        } elseif ($blockStructure instanceof MenuBlockStructure && $blockStructure->type == 'menu') {
            $blockStructureContent = new MenuBlockStructure([
                'menu_id' => $blockStructure->menu_id
            ]);
        } elseif ($blockStructure instanceof ViewFileBlockStructure && $blockStructure->type == 'view_file') {
            $blockStructureContent = new ViewFileBlockStructure([
                'view_file' => $blockStructure->view_file
            ]);
        } elseif ($blockStructure instanceof ArticleBlockStructure && $blockStructure->type == 'article') {
            $blockStructureContent = new ArticleBlockStructure([
                'article_id' => $blockStructure->article_id
            ]);
        } elseif ($blockStructure instanceof ArticleListBlockStructure && $blockStructure->type == 'article_list') {
            $blockStructureContent = new ArticleListBlockStructure([
                'article_list_category_id' => $blockStructure->article_list_category_id,
                'article_list_order' => $blockStructure->article_list_order,
                'article_list_number' => $blockStructure->article_list_number
            ]);
        } elseif ($blockStructure instanceof GlobalBlockStructure && $blockStructure->type == 'global') {
            $blockStructureContent = new GlobalBlockStructure([
                'block_reference_id' => $blockStructure->block_reference_id
            ]);
        }

        $this->updateBlockInteractor->run($blockID, $blockStructureContent);

        return $blockID;
    }
} 