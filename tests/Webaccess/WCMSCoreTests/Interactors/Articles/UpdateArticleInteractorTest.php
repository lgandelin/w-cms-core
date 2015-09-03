<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Article;
use Webaccess\WCMSCore\Interactors\Articles\UpdateArticleInteractor;
use Webaccess\WCMSCore\DataStructure;

class UpdateArticleInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp()
    {
        $this->interactor = new UpdateArticleInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingArticle()
    {
        $articleStructure = new DataStructure([
            'ID' => 1,
            'title' => 'Sample article',
        ]);

        $this->interactor->run($articleStructure);
    }

    public function testUpdateArticle()
    {
        $blockID = $this->createSampleArticle();

        $articleStructureUpdated = new DataStructure([
            'title' => 'Sample article updated'
        ]);

        $this->interactor->run($blockID, $articleStructureUpdated);

        $article = Context::get('article')->findByID($blockID);

        $this->assertEquals('Sample article updated', $article->getTitle());
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateArticleWithEmptyTitle()
    {
        $articleID = $this->createSampleArticle();

        $articleStructureUpdated = new DataStructure([
            'title' => ''
        ]);

        $this->interactor->run($articleID, $articleStructureUpdated);
    }

    private function createSampleArticle()
    {
        $article = new Article();
        $article->setTitle('Sample article');
        Context::get('article')->createArticle($article);

        return $article->getID();
    }
}
