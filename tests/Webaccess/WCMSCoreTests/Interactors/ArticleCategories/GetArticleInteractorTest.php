<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\ArticleCategory;
use Webaccess\WCMSCore\Interactors\ArticleCategories\GetArticleCategoryInteractor;

class GetArticleCategoryInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetArticleCategoryInteractor();
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
        $article->setName('Sample category article');
        Context::get('article_category_repository')->createArticleCategory($article);

        return $article;
    }
}
