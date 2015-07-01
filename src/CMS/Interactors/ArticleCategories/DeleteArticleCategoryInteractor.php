<?php

namespace CMS\Interactors\ArticleCategories;

use CMS\Context;

class DeleteArticleCategoryInteractor extends GetArticleCategoryInteractor
{
    public function run($articleCategoryID)
    {
        if ($this->getArticleCategoryByID($articleCategoryID)) {
            Context::get('article_category')->deleteArticleCategory($articleCategoryID);
        }
    }
}
