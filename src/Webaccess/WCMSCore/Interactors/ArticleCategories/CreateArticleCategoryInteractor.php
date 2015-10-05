<?php

namespace Webaccess\WCMSCore\Interactors\ArticleCategories;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\ArticleCategory;
use Webaccess\WCMSCore\DataStructure;

class CreateArticleCategoryInteractor
{
    public function run(DataStructure $articleCategoryStructure)
    {
        $articleCategory = (new ArticleCategory())->setInfos($articleCategoryStructure);
        $articleCategory->valid();

        return Context::get('article_category_repository')->createArticleCategory($articleCategory);
    }
}
