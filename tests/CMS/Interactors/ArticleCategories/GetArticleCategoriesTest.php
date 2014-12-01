<?php

use CMS\Entities\ArticleCategory;
use CMS\Interactors\ArticleCategories\GetArticleCategoriesInteractor;
use CMS\Repositories\InMemory\InMemoryArticleCategoryRepository;

class GetArticleCategoriesInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryArticleCategoryRepository();
        $this->interactor = new GetArticleCategoriesInteractor($this->repository);
    }

    public function testGetAllWithoutArticleCategories()
    {
        $this->assertCount(0, $this->interactor->getAll());
    }

    public function testGetAll()
    {
        $this->createSampleArticleCategory(1);
        $this->createSampleArticleCategory(2);

        $articleCategories = $this->interactor->getAll();

        $this->assertCount(2, $articleCategories);
        $this->assertInstanceOf('\CMS\Entities\ArticleCategory', $articleCategories[0]);
    }

    public function testGetByStructures()
    {
        $this->createSampleArticleCategory(1);
        $this->createSampleArticleCategory(2);

        $articleCategories = $this->interactor->getAll(true);

        $this->assertCount(2, $articleCategories);
        $this->assertInstanceOf('\CMS\Structures\ArticleCategoryStructure', $articleCategories[0]);
    }

    private function createSampleArticleCategory($articleCategoryID)
    {
        $articleCategory = new ArticleCategory();
        $articleCategory->setID($articleCategoryID);
        $articleCategory->setName('Sample category article');
        $this->repository->createArticleCategory($articleCategory);
    }
}
