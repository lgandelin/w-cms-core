<?php

namespace CMSTests\Repositories;

use CMS\Entities\Article;
use CMS\Repositories\ArticleRepositoryInterface;

class InMemoryArticleRepository implements ArticleRepositoryInterface
{
    private $articles;

    public function __construct()
    {
        $this->articles = [];
    }

    public function findByID($articleID)
    {
        foreach ($this->articles as $article) {
            if ($article->getID() == $articleID) {
                return $article;
            }
        }

        return false;
    }

    public function findByTitle($articleTitle)
    {
        foreach ($this->articles as $article) {
            if ($article->getID() == $articleTitle) {
                return $article;
            }
        }

        return false;
    }

    public function findByPageID($pageID)
    {
        $articles = [];
        foreach ($this->articles as $article) {
            if ($article->getPageID() == $pageID) {
                $articles[]= $article;
            }
        }

        return $articles;
    }

    public function findAll($lang = null)
    {
        return $this->articles;
    }

    public function createArticle(Article $article)
    {
        $this->articles[]= $article;
    }

    public function updateArticle(Article $article)
    {
        foreach ($this->articles as $articleModel) {
            if ($articleModel->getID() == $article->getID()) {
                $articleModel->setTitle($article->getTitle());
                $articleModel->setSummary($article->getSummary());
                $articleModel->setText($article->getText());
                $articleModel->setAuthorID($article->getAuthorID());
            }
        }
    }

    public function deleteArticle($articleID)
    {
        foreach ($this->articles as $i => $article) {
            if ($article->getID() == $articleID) {
                unset($this->articles[$i]);
            }
        }
    }
}
