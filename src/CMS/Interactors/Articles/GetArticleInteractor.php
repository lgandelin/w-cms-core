<?php

namespace CMS\Interactors\Articles;

use CMS\Context;
use CMS\Structures\ArticleStructure;

class GetArticleInteractor
{
    public function getArticleByID($articleID, $structure = false)
    {
        if (!$article = Context::$articleRepository->findByID($articleID)) {
            throw new \Exception('The article was not found');
        }

        return  ($structure) ? ArticleStructure::toStructure($article) : $article;
    }
}
