<?php

use CMS\Entities\ArticleCategory;
use CMS\Interactors\ArticleCategories\UpdateArticleCategoryInteractor;
use CMS\Repositories\InMemory\InMemoryArticleCategoryRepository;
use CMS\Structures\ArticleCategoryStructure;

class UpdateArticleCategoryInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryArticleCategoryRepository();
        $this->interactor = new UpdateArticleCategoryInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingArticleCategory()
    {
        $articleCategoryStructure = new ArticleCategoryStructure([
            'ID' => 1,
            'name' => 'Sample article category',
        ]);

        $this->interactor->run($articleCategoryStructure);
    }

    public function testUpdateArticleCategory()
    {
        $this->createSampleArticleCategory(1);

        $articleCategoryStructureUpdated = new ArticleCategoryStructure([
            'name' => 'Sample article category updated'
        ]);

        $this->interactor->run(1, $articleCategoryStructureUpdated);

        $articleCategory = $this->repository->findByID(1);

        $this->assertEquals('Sample article category updated', $articleCategory->getName());
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateArticleCategoryWithEmptyTitle()
    {
        $this->createSampleArticleCategory(1);

        $articleCategoryStructureUpdated = new ArticleCategoryStructure([
            'name' => ''
        ]);

        $this->interactor->run(1, $articleCategoryStructureUpdated);
    }

    private function createSampleArticleCategory($articleCategoryID)
    {
        $articleCategory = new ArticleCategory();
        $articleCategory->setID($articleCategoryID);
        $articleCategory->setName('Sample article category');
        $this->repository->createArticleCategory($articleCategory);

        return $articleCategory;
    }
}