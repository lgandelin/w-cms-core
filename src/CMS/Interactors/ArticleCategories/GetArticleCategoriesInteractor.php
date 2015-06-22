<?php

namespace CMS\Interactors\ArticleCategories;

use CMS\Context;

class GetArticleCategoriesInteractor
{
    public function getAll($langID = null, $structure = false)
    {
        $articles = Context::getRepository('article_category')->findAll($langID);

        return ($structure) ? $this->getArticleCategoryStructures($articles) : $articles;
    }

    private function getArticleCategoryStructures($articles)
    {
        $articleStructures = [];
        if (is_array($articles) && sizeof($articles) > 0) {
            foreach ($articles as $article) {
                $articleStructures[] = $article->toStructure();
            }
        }

        return $articleStructures;
    }
}
