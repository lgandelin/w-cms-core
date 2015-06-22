<?php

namespace CMS\Interactors\Articles;

use CMS\Context;
use CMS\Entities\Article;
use CMS\DataStructure;

class CreateArticleInteractor
{
    public function run(DataStructure $articleStructure)
    {
        $article = new Article();
        $article->setInfos($articleStructure);
        $article->valid();

        return Context::getRepository('article')->createArticle($article);
    }
}
