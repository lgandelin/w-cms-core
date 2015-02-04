<?php

namespace CMS\Structures\Blocks;

use CMS\Entities\Blocks\ArticleListBlock;
use CMS\Structures\BlockStructure;

class ArticleListBlockStructure extends BlockStructure
{
    public $article_list_category_id;
    public $article_list_order;
    public $article_list_number;

    public function getBlock()
    {
        return new ArticleListBlock();
    }
}
