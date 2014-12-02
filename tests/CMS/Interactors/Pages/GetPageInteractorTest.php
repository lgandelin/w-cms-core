<?php

use CMS\Entities\Page;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Repositories\InMemory\InMemoryPageRepository;

class GetPageInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryPageRepository();
        $this->interactor = new GetPageInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingPage()
    {
        $this->interactor->getPageByID(1);
    }

    public function testGetPageByURI()
    {
        $this->createSamplePage();

        $page = $this->interactor->getPageByURI('/test-page');

        $this->assertEquals('Test page', $page->getName());
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
