<?php

use CMS\Context;
use CMS\Entities\Article;
use CMS\Interactors\Articles\GetArticlesInteractor;

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
        $this->assertInstanceOf('\CMS\Entities\Article', array_shift($articles));
    }

    public function testGetByStructures()
    {
        $this->createSampleArticle();
        $this->createSampleArticle();

        $articles = $this->interactor->getAll(null, null, null, null, true);

        $this->assertCount(2, $articles);
        $this->assertInstanceOf('\CMS\Structures\ArticleStructure', array_shift($articles));
    }

    private function createSampleArticle()
    {
        $article = new Article();
        $article->setTitle('Sample article');
        Context::getRepository('article')->createArticle($article);
    }
}
