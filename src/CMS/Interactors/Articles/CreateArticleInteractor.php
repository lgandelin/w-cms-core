<?php

namespace CMS\Interactors\Articles;

use CMS\Entities\Article;
use CMS\Repositories\ArticleRepositoryInterface;
use CMS\Structures\ArticleStructure;

class CreateArticleInteractor
{
    private $repository;

    public function __construct(ArticleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(ArticleStructure $articleStructure)
    {
        $article = $this->createArticleFromStructure($articleStructure);

        $article->valid();

        return $this->repository->createArticle($article);
    }

    private function createArticleFromStructure(ArticleStructure $articleStructure)
    {
        $article = new Article();
        $article->setID($articleStructure->ID);
        $article->setTitle($articleStructure->title);
        $article->setSummary($articleStructure->summary);
        $article->setText($articleStructure->text);
        $article->setCategoryID($articleStructure->category_id);
        $article->setAuthorID($articleStructure->author_id);
        $article->setPublicationDate($articleStructure->publication_date);

        return $article;
    }
}
