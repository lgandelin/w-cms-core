<?php

use CMS\Context;
use CMS\Interactors\Articles\CreateArticleInteractor;
use CMS\Structures\ArticleStructure;

class CreateArticleInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateArticleInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testCreateArticleWithoutTitle()
    {
        $article = new ArticleStructure([
            'title' => ''
        ]);

        $this->interactor->run($article);
    }

    public function testCreateArticle()
    {
        $this->assertCount(0, Context::$articleRepository->findAll());

        $articleStructure = new ArticleStructure([
            'title' => 'Sample article',
        ]);

        $this->interactor->run($articleStructure);

        $this->assertCount(1, Context::$articleRepository->findAll());
    }
}
