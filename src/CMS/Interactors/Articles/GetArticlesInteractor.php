<?php

namespace CMS\Interactors\Articles;

use CMS\Context;

class GetArticlesInteractor
{
    public function getAll($categoryID = null, $limit = 0, $order = 'ASC', $langID = null, $structure = false)
    {
        $articles = Context::getRepository('article')->findAll($langID, $categoryID, $limit, $order);

        return ($structure) ? $this->getArticleStructures($articles) : $articles;
    }

    private function getArticleStructures($articles)
    {
        $articleStructures = [];
        if (is_array($articles) && sizeof($articles) > 0) {
            foreach ($articles as $article) {
                $articleStructures[] = $article->toStructure();
            }
        }

        return $articleStructures;
    }

    public function getByAssociatedPageID($pageID, $structure = false)
    {
        $articles = Context::getRepository('article')->findByPageID($pageID);

        return ($structure) ? $this->getArticleStructures($articles) : $articles;
    }
}
