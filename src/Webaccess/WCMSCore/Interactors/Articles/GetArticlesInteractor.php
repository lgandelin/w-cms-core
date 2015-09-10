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
        $articles = Context::get('article_repository')->findByPageID($pageID);

        return ($structure) ? $this->getArticleStructures($articles) : $articles;
    }
}
