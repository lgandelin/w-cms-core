<?php

namespace CMS\Interactors\Articles;

use CMS\Context;

class GetArticleInteractor
{
    public function getArticleByID($articleID, $structure = false)
    {
        if (!$article = Context::getRepository('article')->findByID($articleID)) {
            throw new \Exception('The article was not found');
        }

        return  ($structure) ? $article->toStructure() : $article;
    }
}
