<?php

namespace CMS\Interactors\ArticleCategories;

use CMS\Context;
use CMS\Entities\ArticleCategory;
use CMS\Structures\ArticleCategoryStructure;

class CreateArticleCategoryInteractor
{
    public function run(ArticleCategoryStructure $articleCategoryStructure)
    {
        $articleCategory = new ArticleCategory();
        $articleCategory->setInfos($articleCategoryStructure);
        $articleCategory->valid();

        return Context::getRepository('article_category')->createArticleCategory($articleCategory);
    }
}
