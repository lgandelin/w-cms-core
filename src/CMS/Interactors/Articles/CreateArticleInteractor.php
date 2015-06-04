<?php

namespace CMS\Interactors\Articles;

use CMS\Context;
use CMS\Entities\Article;
use CMS\Structures\ArticleStructure;

class CreateArticleInteractor
{
    public function run(ArticleStructure $articleStructure)
    {
        $article = new Article();
        $article->setInfos($articleStructure);
        $article->valid();

        return Context::$articleRepository->createArticle($article);
    }
}
