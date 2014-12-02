<?php

use CMS\Entities\ArticleCategory;
use CMS\Interactors\ArticleCategories\GetArticleCategoryInteractor;
use CMS\Repositories\InMemory\InMemoryArticleCategoryRepository;

class GetArticleCategoryInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryArticleCategoryRepository();
        $this->interactor = new GetArticleCategoryInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingArticleCategory()
    {
        $this->interactor->getArticleCategoryByID(1);
    }

    public function testGetArticleCategory()
    {
        $article = $this->createSampleArticleCategory();

        $this->assertEquals($article, $this->interactor->getArticleCategoryByID(1));
    }

    private function createSampleArticleCategory()
    {
        $article = new ArticleCategory();
        $article->setID(1);
        $article->setName('Sample category article');
        $this->repository->createArticleCategory($article);

        return $article;
    }
}
