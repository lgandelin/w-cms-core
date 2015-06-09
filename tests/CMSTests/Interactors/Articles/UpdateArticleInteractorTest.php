<?php

use CMS\Context;
use CMS\Entities\Article;
use CMS\Interactors\Articles\UpdateArticleInteractor;
use CMS\Structures\ArticleStructure;

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
        $articleStructure = new ArticleStructure([
            'ID' => 1,
            'title' => 'Sample article',
        ]);

        $this->interactor->run($articleStructure);
    }

    public function testUpdateArticle()
    {
        $blockID = $this->createSampleArticle();

        $articleStructureUpdated = new ArticleStructure([
            'title' => 'Sample article updated'
        ]);

        $this->interactor->run($blockID, $articleStructureUpdated);

        $article = Context::getRepository('article')->findByID($blockID);

        $this->assertEquals('Sample article updated', $article->getTitle());
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateArticleWithEmptyTitle()
    {
        $articleID = $this->createSampleArticle();

        $articleStructureUpdated = new ArticleStructure([
            'title' => ''
        ]);

        $this->interactor->run($articleID, $articleStructureUpdated);
    }

    private function createSampleArticle()
    {
        $article = new Article();
        $article->setTitle('Sample article');
        Context::getRepository('article')->createArticle($article);

        return $article->getID();
    }
}
