<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\ArticleCategory;
use Webaccess\WCMSCore\Interactors\ArticleCategories\DeleteArticleCategoryInteractor;

class DeleteArticlecategoryInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp()
    {
        CMSTestsSuite::clean();
        $this->interactor = new DeleteArticleCategoryInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingArticlecategory()
    {
        $this->interactor->run(1);
    }

    public function testDeleteArticlecategory()
    {
        $this->createSampleArticlecategory();

        $this->assertCount(1, Context::get('article_category')->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, Context::get('article_category')->findAll());
    }

    private function createSampleArticlecategory()
    {
        $articleCategory = new Articlecategory();
        $articleCategory->setID(1);
        $articleCategory->setName('Sample article category');
        Context::get('article_category')->createArticlecategory($articleCategory);
    }
}
