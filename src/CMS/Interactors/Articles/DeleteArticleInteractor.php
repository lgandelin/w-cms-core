<?php

namespace CMS\Interactors\Articles;

use CMS\Context;

class DeleteArticleInteractor extends GetArticleInteractor
{
    public function run($articleID)
    {
        if ($this->getArticleByID($articleID)) {
            Context::$articleRepository->deleteArticle($articleID);
        }
    }
}
