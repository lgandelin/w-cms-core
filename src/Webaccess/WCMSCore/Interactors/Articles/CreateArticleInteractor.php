<?php

namespace Webaccess\WCMSCore\Interactors\Articles;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Article;
use Webaccess\WCMSCore\DataStructure;

class CreateArticleInteractor
{
    public function run(DataStructure $articleStructure)
    {
        $article = new Article();
        $article->setInfos($articleStructure);
        $article->valid();

        return Context::get('article')->createArticle($article);
    }
}
