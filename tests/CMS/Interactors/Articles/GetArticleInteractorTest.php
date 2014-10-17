<?php

use CMS\Entities\Article;
use CMS\Interactors\Articles\GetArticleInteractor;
use CMS\Repositories\InMemory\InMemoryArticleRepository;

class GetArticleInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryArticleRepository();
        $this->interactor = new GetArticleInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingArticle()
    {
        $this->interactor->getArticleByID(1);
    }

    public function testGetArticle()
    {
        $article = $this->createSampleArticle();

        $this->assertEquals($article, $this->interactor->getArticleByID(1));
    }

    private function createSampleArticle()
    {
        $article = new Article();
        $article->setID(1);
        $article->setTitle('Sample article');
        $this->repository->createArticle($article);

        return $article;
    }
}
 