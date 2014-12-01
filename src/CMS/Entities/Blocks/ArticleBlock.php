<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;

class ArticleBlock extends Block
{
    private $articleID;

    public function setArticleID($articleID)
    {
        $this->articleID = $articleID;
    }

    public function getArticleID()
    {
        return $this->articleID;
    }
}
