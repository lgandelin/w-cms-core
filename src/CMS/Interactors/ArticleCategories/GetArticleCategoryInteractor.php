<?php

namespace CMS\Interactors\ArticleCategories;

use CMS\Context;

class GetArticleCategoryInteractor
{
    public function getArticleCategoryByID($articleID, $structure = false)
    {
        if (!$article = Context::get('article_category')->findByID($articleID)) {
            throw new \Exception('The article was not found');
        }

        return  ($structure) ? $article->toStructure() : $article;
    }
}
