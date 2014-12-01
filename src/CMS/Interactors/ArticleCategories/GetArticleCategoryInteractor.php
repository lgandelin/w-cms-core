<?php

namespace CMS\Interactors\ArticleCategories;

use CMS\Repositories\ArticleCategoryRepositoryInterface;
use CMS\Structures\ArticleCategoryStructure;

class GetArticleCategoryInteractor
{
    protected $repository;

    public function __construct(ArticleCategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getArticleCategoryByID($articleID, $structure = false)
    {
        if (!$article = $this->repository->findByID($articleID)) {
            throw new \Exception('The article was not found');
        }

        return  ($structure) ? ArticleCategoryStructure::toStructure($article) : $article;
    }
}
