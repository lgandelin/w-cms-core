<?php

namespace Webaccess\WCMSCore\Interactors\ArticleCategories;

use Webaccess\WCMSCore\Context;

class DeleteArticleCategoryInteractor extends GetArticleCategoryInteractor
{
    public function run($articleCategoryID)
    {
        if ($this->getArticleCategoryByID($articleCategoryID)) {
            Context::get('article_category_repository')->deleteArticleCategory($articleCategoryID);
        }
    }
}
