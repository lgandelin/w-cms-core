<?php

use CMS\Interactors\ArticleCategories\CreateArticleCategoryInteractor;
use CMS\Repositories\InMemory\InMemoryArticleCategoryRepository;
use CMS\Structures\ArticleCategoryStructure;

class CreateArticleCategoryInteractorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->repository = new InMemoryArticleCategoryRepository();
        $this->interactor = new CreateArticleCategoryInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateArticleCategoryWithoutTitle()
    {
        $article = new ArticleCategoryStructure([
            'name' => ''
        ]);

        $this->interactor->run($article);
    }

    public function testCreateArticleCategory()
    {
        $this->assertCount(0, $this->repository->findAll());

        $articleStructure = new ArticleCategoryStructure([
            'name' => 'Sample article category',
        ]);

        $this->interactor->run($articleStructure);

        $this->assertCount(1, $this->repository->findAll());
    }
}
