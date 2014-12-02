<?php

namespace CMS\Repositories;

use CMS\Entities\Article;

interface ArticleRepositoryInterface
{
    public function findByID($articleID);

    public function findByTitle($articleTitle);

    public function findAll();

    public function createArticle(Article $article);

    public function updateArticle(Article $article);

    public function deleteArticle($articleID);
}
