<?php

namespace CMS\Repositories;

use CMS\Entities\ArticleCategory;

interface ArticleCategoryRepositoryInterface
{
    public function findByID($articleCategoryID);

    public function findAll();

    public function createArticleCategory(ArticleCategory $articleCategory);

    public function updateArticleCategory(ArticleCategory $articleCategory);

    public function deleteArticleCategory($articleCategoryID);
}