<?php

use CMS\Entities\Article;
use CMS\Interactors\Articles\GetArticlesInteractor;
use CMS\Repositories\InMemory\InMemoryArticleRepository;

class GetArticlesInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryArticleRepository();
        $this->interactor = new GetArticlesInteractor($this->repository);
    }

    public function testGetAllWithoutArticles()
    {
        $this->assertCount(0, $this->interactor->getAll());
    }

    public function testGetAll()
    {
        $this->createSampleArticle(1);
        $this->createSampleArticle(2);

        $articles = $this->interactor->getAll();

        $this->assertCount(2, $articles);
        $this->assertInstanceOf('\CMS\Entities\Article', $articles[0]);
    }

    public function testGetByStructures()
    {
        $this->createSampleArticle(1);
        $this->createSampleArticle(2);

        $articles = $this->interactor->getAll(true);

        $this->assertCount(2, $articles);
        $this->assertInstanceOf('\CMS\Structures\ArticleStructure', $articles[0]);
    }

    private function createSampleArticle($articleID)
    {
        $article = new Article();
        $article->setID($articleID);
        $article->setTitle('Sample article');
        $this->repository->createArticle($article);
    }
}
