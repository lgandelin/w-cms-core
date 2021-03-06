<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\ArticleCategory;
use Webaccess\WCMSCore\Interactors\ArticleCategories\GetArticleCategoriesInteractor;

class GetArticleCategoriesInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetArticleCategoriesInteractor();
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
        $this->assertInstanceOf('\Webaccess\WCMSCore\Entities\ArticleCategory', Context::get('article_category_repository')->findByID(1));
    }

    public function testGetByStructures()
    {
        $this->createSampleArticleCategory(1);
        $this->createSampleArticleCategory(2);

        $articleCategories = $this->interactor->getAll(null, true);

        $this->assertCount(2, $articleCategories);
    }

    private function createSampleArticleCategory($articleCategoryID)
    {
        $articleCategory = new ArticleCategory();
        $articleCategory->setID($articleCategoryID);
        $articleCategory->setName('Sample category article');
        Context::get('article_category_repository')->createArticleCategory($articleCategory);
    }
}
