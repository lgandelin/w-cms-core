<?php

use CMS\Entities\Article;
use CMS\Interactors\Articles\DeleteArticleInteractor;
use CMS\Repositories\InMemory\InMemoryArticleRepository;

class DeleteArticleInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryArticleRepository();
        $this->interactor = new DeleteArticleInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingArticle()
    {
        $this->interactor->run(1);
    }

    public function testDeleteArticle()
    {
        $this->createSampleArticle();

        $this->assertCount(1, $this->repository->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, $this->repository->findAll());
    }

    private function createSampleArticle()
    {
        $article = new Article();
        $article->setID(1);
        $article->setTitle('Sample article');
        $this->repository->createArticle($article);
    }
}
