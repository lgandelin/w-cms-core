<?php

namespace CMS\Interactors\Articles;

use CMS\Repositories\ArticleRepositoryInterface;
use CMS\Structures\ArticleStructure;

class GetArticleInteractor
{
    protected $repository;

    public function __construct(ArticleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getArticleByID($articleID, $structure = false)
    {
        if (!$article = $this->repository->findByID($articleID)) {
            throw new \Exception('The article was not found');
        }

        return  ($structure) ? ArticleStructure::toStructure($article) : $article;
    }
}
