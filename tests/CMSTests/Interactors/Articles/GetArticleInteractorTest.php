<?php

use CMS\Context;
use CMS\Entities\Article;
use CMS\Interactors\Articles\GetArticleInteractor;

class GetArticleInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp()
    {
        CMSTestsSuite::clean();
        $this->interactor = new GetArticleInteractor(Context::$articleRepository);
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingArticle()
    {
        $this->interactor->getArticleByID(1);
    }

    public function testGetArticle()
    {
        $articleID = $this->createSampleArticle();

        $this->assertInstanceOf('CMS\Entities\Article', $this->interactor->getArticleByID($articleID));
    }

    private function createSampleArticle()
    {
        $article = new Article();
        $article->setTitle('Sample article');
        Context::$articleRepository->createArticle($article);

        return $article->getID();
    }
}
