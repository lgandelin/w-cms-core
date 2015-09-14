<?php

namespace Webaccess\WCMSCore\Interactors\Articles;

use Webaccess\WCMSCore\Context;

class GetArticleInteractor
{
    public function getArticleByID($articleID, $structure = false)
    {
        if (!$article = Context::get('article_repository')->findByID($articleID)) {
            throw new \Exception('The article was not found');
        }

        return  ($structure) ? $article->toStructure() : $article;
    }
}
