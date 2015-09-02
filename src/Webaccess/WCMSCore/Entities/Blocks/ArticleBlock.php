<?php

namespace Webaccess\WCMSCore\Entities\Blocks;

use Webaccess\WCMSCore\Entities\Block;
use Webaccess\WCMSCore\Interactors\Articles\GetArticleInteractor;

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
