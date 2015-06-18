<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Interactors\Articles\GetArticleInteractor;

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

    public function getContentData()
    {
        if ($this->getArticleID()) {
            $content = (new GetArticleInteractor())->getArticleByID($this->getArticleID(), true);

            return $content;
        }

        return null;
    }
}
