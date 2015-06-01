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
        $this->interactor = new DeleteArticleInteractor(Context::$articleRepository);
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

        $this->assertCount(1, Context::$articleRepository->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, Context::$articleRepository->findAll());
    }

    private function createSampleArticle()
    {
        $article = new Article();
        $article->setID(1);
        $article->setTitle('Sample article');
        Context::$articleRepository->createArticle($article);
    }
}
