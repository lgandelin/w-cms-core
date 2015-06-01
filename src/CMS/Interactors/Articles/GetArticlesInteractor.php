<?php

namespace CMS\Interactors\Articles;

use CMS\Context;
use CMS\Structures\ArticleStructure;

class GetArticlesInteractor
{
    public function getAll($langID = null, $structure = false, $categoryID = null, $limit = 0, $order = 'ASC')
    {
        $articles = Context::$articleRepository->findAll($langID, $categoryID, $limit, $order);

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
        $articles = Context::$articleRepository->findByPageID($pageID);

        return ($structure) ? $this->getArticleStructures($articles) : $articles;
    }
}
