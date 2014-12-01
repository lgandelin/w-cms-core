<?php

namespace CMS\Interactors\Articles;

class DeleteArticleInteractor extends GetArticleInteractor
{
    public function run($articleID)
    {
        if ($this->getArticleByID($articleID)) {
            $this->repository->deleteArticle($articleID);
        }
    }
}
