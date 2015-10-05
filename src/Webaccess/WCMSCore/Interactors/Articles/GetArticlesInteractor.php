<?php

namespace Webaccess\WCMSCore\Interactors\Articles;

use Webaccess\WCMSCore\Context;

class GetArticlesInteractor
{
    public function getAll($categoryID = null, $limit = 0, $order = 'ASC', $langID = null, $structure = false)
    {
        $articles = Context::get('article_repository')->findAll($langID, $categoryID, $limit, $order);

        return ($structure) ? $this->getArticleStructures($articles) : $articles;
    }

    private function getArticleStructures($articles)
    {
        return array_map(function($article) {
            return $article->toStructure();
        }, $articles);
    }

    public function getByAssociatedPageID($pageID, $structure = false)
    {
        $articles = Context::get('article_repository')->findByPageID($pageID);

        return ($structure) ? $this->getArticleStructures($articles) : $articles;
    }
}
