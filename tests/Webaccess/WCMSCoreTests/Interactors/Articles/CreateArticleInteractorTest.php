<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Articles\CreateArticleInteractor;
use Webaccess\WCMSCore\DataStructure;

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
        $article = new DataStructure([
            'title' => ''
        ]);

        $this->interactor->run($article);
    }

    public function testCreateArticle()
    {
        $this->assertCount(0, Context::get('article')->findAll());

        $articleStructure = new DataStructure([
            'title' => 'Sample article',
        ]);

        $this->interactor->run($articleStructure);

        $this->assertCount(1, Context::get('article')->findAll());
    }
}
