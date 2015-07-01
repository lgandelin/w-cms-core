<?php

namespace CMS\Interactors\ArticleCategories;

use CMS\Context;
use CMS\DataStructure;

class UpdateArticleCategoryInteractor extends GetArticleCategoryInteractor
{
    public function run($articleCategoryID, DataStructure $articleCategoryStructure)
    {
        if ($articleCategory = $this->getArticleCategoryByID($articleCategoryID)) {
            $articleCategory->setInfos($articleCategoryStructure);
            $articleCategory->valid();

            Context::get('article_category')->updateArticleCategory($articleCategory);
        }
    }
}
