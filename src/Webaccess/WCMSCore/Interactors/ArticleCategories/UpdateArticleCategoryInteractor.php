<?php

namespace Webaccess\WCMSCore\Interactors\ArticleCategories;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;

class UpdateArticleCategoryInteractor extends GetArticleCategoryInteractor
{
    public function run($articleCategoryID, DataStructure $articleCategoryStructure)
    {
        if ($articleCategory = $this->getArticleCategoryByID($articleCategoryID)) {
            $articleCategory->setInfos($articleCategoryStructure);
            $articleCategory->valid();

            Context::get('article_category_repository')->updateArticleCategory($articleCategory);
        }
    }
}
