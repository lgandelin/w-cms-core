<?php

namespace CMS\Interactors\ArticleCategories;

use CMS\Context;
use CMS\Structures\ArticleCategoryStructure;

class UpdateArticleCategoryInteractor extends GetArticleCategoryInteractor
{
    public function run($articleCategoryID, ArticleCategoryStructure $articleCategoryStructure)
    {
        if ($articleCategory = $this->getArticleCategoryByID($articleCategoryID)) {
            $articleCategory->setInfos($articleCategoryStructure);
            $articleCategory->valid();

            Context::getRepository('article_category')->updateArticleCategory($articleCategory);
        }
    }
}
