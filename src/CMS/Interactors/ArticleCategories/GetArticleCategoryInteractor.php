<?php

namespace CMS\Interactors\ArticleCategories;

use CMS\Context;
use CMS\Structures\ArticleCategoryStructure;

class GetArticleCategoryInteractor
{
    public function getArticleCategoryByID($articleID, $structure = false)
    {
        if (!$article = Context::getRepository('article_category')->findByID($articleID)) {
            throw new \Exception('The article was not found');
        }

        return  ($structure) ? ArticleCategoryStructure::toStructure($article) : $article;
    }
}
