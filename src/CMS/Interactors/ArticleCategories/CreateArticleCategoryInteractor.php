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
        $article = $this->createArticleCategoryFromStructure($articleStructure);

        $article->valid();

        return $this->repository->createArticleCategory($article);
    }

    private function createArticleCategoryFromStructure(ArticleCategoryStructure $articleStructure)
    {
        $article = new ArticleCategory();
        $article->setID($articleStructure->ID);
        $article->setName($articleStructure->name);
        $article->setDescription($articleStructure->description);

        return $article;
    }
}
