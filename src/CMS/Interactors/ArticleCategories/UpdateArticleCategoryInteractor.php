<?php

namespace CMS\Interactors\ArticleCategories;

use CMS\Structures\ArticleCategoryStructure;

class UpdateArticleCategoryInteractor extends GetArticleCategoryInteractor
{
    public function run($articleID, ArticleCategoryStructure $articleStructure)
    {
        if ($article = $this->getArticleCategoryByID($articleID)) {

            if (isset($articleStructure->name) && $articleStructure->name !== null && $article->getName() != $articleStructure->name) $article->setName($articleStructure->name);
            if (isset($articleStructure->description) && $articleStructure->description !== null && $article->getDescription() != $articleStructure->description) $article->setDescription($articleStructure->description);

            $article->valid();

            $this->repository->updateArticleCategory($article);
        }
    }

}