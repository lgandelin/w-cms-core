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

    public function getAll($langID = null, $structure = false, $categoryID = null, $limit = 0, $order = 'ASC')
    {
        $articles = $this->repository->findAll($langID, $categoryID, $limit, $order);

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

    public function getByAssociatedPageID($pageID, $structure = false)
    {
        $articles = $this->repository->findByPageID($pageID);

        return ($structure) ? $this->getArticleStructures($articles) : $articles;
    }
}
