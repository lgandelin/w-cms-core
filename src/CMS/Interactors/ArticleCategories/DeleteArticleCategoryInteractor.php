<?php

namespace CMS\Interactors\ArticleCategories;

class DeleteArticleCategoryInteractor extends GetArticleCategoryInteractor
{
    public function run($articleCategoryID)
    {
        if ($this->getArticleCategoryByID($articleCategoryID))
            $this->repository->deleteArticleCategory($articleCategoryID);
    }
}