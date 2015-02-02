<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Structures\Blocks\ArticleBlockStructure;

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

    public function getStructure()
    {
        $blockStructure = new ArticleBlockStructure();
        $blockStructure->article_id = $this->getArticleID();

        return $blockStructure;
    }

    public function updateContent(ArticleBlockStructure $blockStructure)
    {
        if ($blockStructure->article_id != $this->getArticleID()) {
            $this->setArticleID($blockStructure->article_id);
        }
    }
}
