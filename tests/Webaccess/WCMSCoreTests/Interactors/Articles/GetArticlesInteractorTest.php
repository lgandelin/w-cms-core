<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Article;
use Webaccess\WCMSCore\Interactors\Articles\GetArticlesInteractor;

class GetArticlesInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp()
    {
        CMSTestsSuite::clean();
        $this->interactor = new GetArticlesInteractor();
    }

    public function testGetAllWithoutArticles()
    {
        $this->assertCount(0, $this->interactor->getAll());
    }

    public function testGetAll()
    {
        $this->createSampleArticle();
        $this->createSampleArticle();

        $articles = $this->interactor->getAll();

        $this->assertCount(2, $articles);
        $this->assertInstanceOf('\Webaccess\WCMSCore\Entities\Article', array_shift($articles));
    }

    public function testGetByStructures()
    {
        $this->createSampleArticle();
        $this->createSampleArticle();

        $articles = $this->interactor->getAll(null, null, null, null, true);

        $this->assertCount(2, $articles);
        $this->assertInstanceOf('\Webaccess\WCMSCore\DataStructure', array_shift($articles));
    }

    private function createSampleArticle()
    {
        $article = new Article();
        $article->setTitle('Sample article');
        Context::get('article_repository')->createArticle($article);
    }
}
