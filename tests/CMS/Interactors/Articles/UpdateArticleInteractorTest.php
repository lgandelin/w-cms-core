<?php

use CMS\Entities\Article;
use CMS\Interactors\Articles\UpdateArticleInteractor;
use CMS\Repositories\InMemory\InMemoryArticleRepository;
use CMS\Structures\ArticleStructure;

class UpdateArticleInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryArticleRepository();
        $this->interactor = new UpdateArticleInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingArticle()
    {
        $articleStructure = new ArticleStructure([
            'ID' => 1,
            'title' => 'Sample article',
        ]);

        $this->interactor->run($articleStructure);
    }

    public function testUpdateArticle()
    {
        $this->createSampleArticle(1);

        $articleStructureUpdated = new ArticleStructure([
            'title' => 'Sample article updated'
        ]);

        $this->interactor->run(1, $articleStructureUpdated);

        $article = $this->repository->findByID(1);

        $this->assertEquals('Sample article updated', $article->getTitle());
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateArticleWithEmptyTitle()
    {
        $this->createSampleArticle(1);

        $articleStructureUpdated = new ArticleStructure([
            'title' => ''
        ]);

        $this->interactor->run(1, $articleStructureUpdated);
    }

    private function createSampleArticle($articleID)
    {
        $article = new Article();
        $article->setID($articleID);
        $article->setTitle('Sample article');
        $this->repository->createArticle($article);

        return $article;
    }
}
