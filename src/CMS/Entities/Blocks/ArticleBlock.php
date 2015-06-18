<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Interactors\Articles\GetArticleInteractor;
use CMS\Structures\DataStructure;

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

    public function updateContent(DataStructure $blockStructure)
    {
        if ($blockStructure->article_id != $this->getArticleID()) {
            $this->setArticleID($blockStructure->article_id);
        }
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
