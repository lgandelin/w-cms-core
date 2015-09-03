<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\ArticleCategories\CreateArticleCategoryInteractor;
use Webaccess\WCMSCore\DataStructure;

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
        $article = new DataStructure([
            'name' => ''
        ]);

        $this->interactor->run($article);
    }

    public function testCreateArticleCategory()
    {
        $this->assertCount(0, Context::get('article_category')->findAll());

        $articleStructure = new DataStructure([
            'name' => 'Sample article category',
        ]);

        $this->interactor->run($articleStructure);

        $this->assertCount(1, Context::get('article_category')->findAll());
    }
}
