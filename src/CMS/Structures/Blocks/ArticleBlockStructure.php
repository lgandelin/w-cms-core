<?php

namespace CMS\Structures\Blocks;

use CMS\Entities\Blocks\ArticleBlock;
use CMS\Structures\BlockStructure;

class ArticleBlockStructure extends BlockStructure
{
    public $article_id;

    public function getBlock()
    {
        return new ArticleBlock();
    }
}
