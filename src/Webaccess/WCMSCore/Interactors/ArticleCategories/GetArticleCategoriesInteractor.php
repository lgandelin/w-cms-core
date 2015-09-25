<?php

namespace Webaccess\WCMSCore\Interactors\ArticleCategories;

use Webaccess\WCMSCore\Context;

class GetArticleCategoriesInteractor
{
    public function getAll($langID = null, $structure = false)
    {
        $articles = Context::get('article_category_repository')->findAll($langID);

        return ($structure) ? $this->getArticleCategoryStructures($articles) : $articles;
    }

    private function getArticleCategoryStructures($articles)
    {
        return array_map(function($article) {
            return $article->toStructure();
        }, $articles);
    }
}
