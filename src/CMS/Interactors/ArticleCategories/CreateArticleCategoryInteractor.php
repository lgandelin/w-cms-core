<?php

namespace CMS\Interactors\ArticleCategories;

use CMS\Entities\ArticleCategory;
use CMS\Repositories\ArticleCategoryRepositoryInterface;
use CMS\Structures\ArticleCategoryStructure;

class CreateArticleCategoryInteractor
{
    private $repository;

    public function __construct(ArticleCategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(ArticleCategoryStructure $articleStructure)
    {
        $articleCategory = $this->createArticleCategoryFromStructure($articleStructure);

        $articleCategory->valid();

        return $this->repository->createArticleCategory($articleCategory);
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
