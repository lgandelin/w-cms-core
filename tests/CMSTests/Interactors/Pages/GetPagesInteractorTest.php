<?php

use CMS\Entities\Page;
use CMS\Interactors\Pages\GetPagesInteractor;
use CMSTests\Repositories\InMemoryPageRepository;

class GetPagesInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryPageRepository();
        $this->interactor = new GetPagesInteractor($this->repository);
    }

    public function testGetAllWithoutPages()
    {
        $this->assertCount(0, $this->interactor->getAll());
    }

    public function testGetAll()
    {
        $this->createSamplePage();
        $this->createSamplePage();

        $pages = $this->interactor->getAll();

        $this->assertEquals(2, count($pages));
        $this->assertInstanceOf('\CMS\Entities\Page', $pages[0]);
    }

    public function testGetAllByStructures()
    {
        $this->createSamplePage();
        $this->createSamplePage();

        $pages = $this->interactor->getAll(true);

        $this->assertEquals(2, count($pages));
        $this->assertInstanceOf('\CMS\Structures\PageStructure', $pages[0]);
    }
    private function createSamplePage()
    {
        $page = new Page();
        $page->setID(1);
        $page->setName('Test page');
        $page->setIdentifier('test-page');
        $page->setURI('/test-page');

        $this->repository->createPage($page);
    }
}
