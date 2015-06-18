<?php

namespace CMS\Structures\Blocks;

use CMS\Entities\Blocks\ArticleBlock;
use CMS\Structures\DataStructure;

class ArticleBlockStructure extends DataStructure
{
    public $article_id;

    public function getBlock()
    {
        return new ArticleBlock();
    }
}
