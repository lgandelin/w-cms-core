<?php

namespace CMS\Interactors\ArticleCategories;

use CMS\Context;
use CMS\Entities\ArticleCategory;
use CMS\Structures\ArticleCategoryStructure;

class CreateArticleCategoryInteractor
{
    public function run(ArticleCategoryStructure $articleStructure)
    {
        $articleCategory = $this->createArticleCategoryFromStructure($articleStructure);

        $articleCategory->valid();

        return Context::$articleCategoryRepository->createArticleCategory($articleCategory);
    }

    private function createArticleCategoryFromStructure(ArticleCategoryStructure $articleStructure)
    {
        $articleCategory = new ArticleCategory();
        $articleCategory->setID($articleStructure->ID);
        $articleCategory->setName($articleStructure->name);
        $articleCategory->setDescription($articleStructure->description);
        $articleCategory->setLangID($articleStructure->lang_id);

        return $articleCategory;
    }
}
