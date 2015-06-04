<?php

use CMS\Context;
use CMS\Interactors\ArticleCategories\CreateArticleCategoryInteractor;
use CMS\Structures\ArticleCategoryStructure;

class CreateArticleCategoryInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateArticleCategoryInteractor();
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
        $this->assertCount(0, Context::$articleCategoryRepository->findAll());

        $articleStructure = new ArticleCategoryStructure([
            'name' => 'Sample article category',
        ]);

        $this->interactor->run($articleStructure);

        $this->assertCount(1, Context::$articleCategoryRepository->findAll());
    }
}
