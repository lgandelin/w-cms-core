<?php

namespace CMS\Interactors\Articles;

use CMS\Repositories\ArticleRepositoryInterface;
use CMS\Structures\ArticleStructure;

class GetArticlesInteractor
{
    private $repository;

    public function __construct(ArticleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll($structure = false)
    {
        $articles = $this->repository->findAll();

        return ($structure) ? $this->getArticleStructures($articles) : $articles;
    }

    public function getByCategoryID($categoryID, $limit, $order, $structure = false)
    {
        $articles = $this->repository->findByCategoryID($categoryID, $limit, $order);

        return ($structure) ? $this->getArticleStructures($articles) : $articles;
    }

    private function getArticleStructures($articles)
    {
        $articleStructures = [];
        if (is_array($articles) && sizeof($articles) > 0) {
            foreach ($articles as $article) {
                $articleStructures[] = ArticleStructure::toStructure($article);
            }
        }

        return $articleStructures;
    }
}
