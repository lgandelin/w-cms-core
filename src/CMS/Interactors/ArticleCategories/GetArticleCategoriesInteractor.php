<?php

namespace CMS\Interactors\ArticleCategories;

use CMS\Repositories\ArticleCategoryRepositoryInterface;
use CMS\Structures\ArticleCategoryStructure;

class GetArticleCategoriesInteractor
{
    private $repository;

    public function __construct(ArticleCategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll($structure = false)
    {
        $articles = $this->repository->findAll();

        return ($structure) ? $this->getArticleCategoryStructures($articles) : $articles;
    }

    private function getArticleCategoryStructures($articles)
    {
        $articleStructures = [];
        if (is_array($articles) && sizeof($articles) > 0) {
            foreach ($articles as $article) {
                $articleStructures[] = ArticleCategoryStructure::toStructure($article);
            }
        }

        return $articleStructures;
    }
}
