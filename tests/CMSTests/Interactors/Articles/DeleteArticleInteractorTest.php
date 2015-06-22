<?php

use CMS\Context;
use CMS\Entities\Article;
use CMS\Interactors\Articles\DeleteArticleInteractor;

class DeleteArticleInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp()
    {
        CMSTestsSuite::clean();
        $this->interactor = new DeleteArticleInteractor(Context::getRepository('article'));
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingArticle()
    {
        $this->interactor->run(1);
    }

    public function testDeleteArticle()
    {
        $this->createSampleArticle();

        $this->assertCount(1, Context::getRepository('article')->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, Context::getRepository('article')->findAll());
    }

    private function createSampleArticle()
    {
        $article = new Article();
        $article->setID(1);
        $article->setTitle('Sample article');
        Context::getRepository('article')->createArticle($article);
    }
}
