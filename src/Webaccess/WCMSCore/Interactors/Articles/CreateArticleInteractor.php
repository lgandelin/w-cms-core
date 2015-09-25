<?php

namespace Webaccess\WCMSCore\Interactors\Articles;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Article;
use Webaccess\WCMSCore\DataStructure;

class CreateArticleInteractor
{
    public function run(DataStructure $articleStructure)
    {
        $article = (new Article())->setInfos($articleStructure);
        $article->valid();

        return Context::get('article_repository')->createArticle($article);
    }
}
