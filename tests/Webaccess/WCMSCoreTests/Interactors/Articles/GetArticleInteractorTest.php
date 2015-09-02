<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Article;
use Webaccess\WCMSCore\Interactors\Articles\GetArticleInteractor;

class GetArticleInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp()
    {
        CMSTestsSuite::clean();
        $this->interactor = new GetArticleInteractor(Context::get('article'));
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

        $this->assertInstanceOf('Webaccess\WCMSCore\Entities\Article', $this->interactor->getArticleByID($articleID));
    }

    private function createSampleArticle()
    {
        $article = new Article();
        $article->setTitle('Sample article');
        Context::get('article')->createArticle($article);

        return $article->getID();
    }
}
