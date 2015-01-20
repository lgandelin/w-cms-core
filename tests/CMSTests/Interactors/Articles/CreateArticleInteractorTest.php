<?php

use CMS\Interactors\Articles\CreateArticleInteractor;
use CMSTests\Repositories\InMemoryArticleRepository;
use CMS\Structures\ArticleStructure;

class CreateArticleInteractorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->repository = new InMemoryArticleRepository();
        $this->interactor = new CreateArticleInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateArticleWithoutTitle()
    {
        $article = new ArticleStructure([
            'title' => ''
        ]);

        $this->interactor->run($article);
    }

    public function testCreateArticle()
    {
        $this->assertCount(0, $this->repository->findAll());

        $articleStructure = new ArticleStructure([
            'title' => 'Sample article',
        ]);

        $this->interactor->run($articleStructure);

        $this->assertCount(1, $this->repository->findAll());
    }
}
