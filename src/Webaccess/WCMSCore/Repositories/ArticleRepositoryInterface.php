<?php

namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\Article;

interface ArticleRepositoryInterface
{
    public function findByID($articleID);

    public function findByTitle($articleTitle);

    public function findByPageID($pageID);

    public function findAll($lang = null);

    public function createArticle(Article $article);

    public function updateArticle(Article $article);

    public function deleteArticle($articleID);
}
