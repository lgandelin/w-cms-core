<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\ArticleCategory;
use Webaccess\WCMSCore\Interactors\ArticleCategories\UpdateArticleCategoryInteractor;
use Webaccess\WCMSCore\DataStructure;

class UpdateArticleCategoryInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new UpdateArticleCategoryInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingArticleCategory()
    {
        $articleCategoryStructure = new DataStructure([
            'ID' => 1,
            'name' => 'Sample article category',
        ]);

        $this->interactor->run($articleCategoryStructure);
    }

    public function testUpdateArticleCategory()
    {
        $this->createSampleArticleCategory(1);

        $articleCategoryStructureUpdated = new DataStructure([
            'name' => 'Sample article category updated'
        ]);

        $this->interactor->run(1, $articleCategoryStructureUpdated);

        $articleCategory = Context::get('article_category_repository')->findByID(1);

        $this->assertEquals('Sample article category updated', $articleCategory->getName());
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateArticleCategoryWithEmptyTitle()
    {
        $this->createSampleArticleCategory(1);

        $articleCategoryStructureUpdated = new DataStructure([
            'name' => ''
        ]);

        $this->interactor->run(1, $articleCategoryStructureUpdated);
    }

    private function createSampleArticleCategory($articleCategoryID)
    {
        $articleCategory = new ArticleCategory();
        $articleCategory->setID($articleCategoryID);
        $articleCategory->setName('Sample article category');
        Context::get('article_category_repository')->createArticleCategory($articleCategory);

        return $articleCategory;
    }
}
