<?php

namespace CMS\Interactors\ArticleCategories;

use CMS\Context;
use CMS\Entities\ArticleCategory;
use CMS\Structures\DataStructure;

class CreateArticleCategoryInteractor
{
    public function run(DataStructure $articleCategoryStructure)
    {
        $articleCategory = new ArticleCategory();
        $articleCategory->setInfos($articleCategoryStructure);
        $articleCategory->valid();

        return Context::getRepository('article_category')->createArticleCategory($articleCategory);
    }
}
