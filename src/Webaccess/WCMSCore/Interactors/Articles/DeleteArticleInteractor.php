<?php

namespace Webaccess\WCMSCore\Interactors\Articles;

use Webaccess\WCMSCore\Context;

class DeleteArticleInteractor extends GetArticleInteractor
{
    public function run($articleID)
    {
        if ($this->getArticleByID($articleID)) {
            Context::get('article_repository')->deleteArticle($articleID);
        }
    }
}
