<?php

use CMS\Converters\PageConverter;
use CMS\Entities\Page;
use CMS\Interactors\Pages\UpdatePageInteractor;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\PageStructure;

class UpdatePageInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryPageRepository();
        $this->interactor = new UpdatePageInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingPage()
    {
        $pageStructure = new PageStructure([
            'ID' => 1,
            'name' => 'Page'
        ]);

        $this->interactor->run(1, $pageStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdatePageWithInvalidURI()
    {
        $pageStructure = new PageStructure([
            'ID' => 1,
            'name' => 'Page',
            'uri' => ''
        ]);

        $this->repository->createPage($pageStructure);

        $this->interactor->run(1, $pageStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdatePageWithAlreadyExistingPageWithSameURI()
    {
        $pageStructure = new PageStructure([
            'ID' => 1,
            'name' => 'Page 1',
            'uri' => '/my-page',
            'identifier' => 'page-1'
        ]);

        $this->repository->createPage($pageStructure);

        $pageStructure2 = new PageStructure([
            'ID' => 2,
            'name' => 'Page 2',
            'uri' => '/page-2',
            'identifier' => 'page-2'
        ]);

        $this->repository->createPage($pageStructure2);

        $pageStructure2Updated = new PageStructure([
           'uri' => '/my-page'
        ]);

        $this->interactor->run(2, $pageStructure2Updated);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdatePageWithAlreadyExistingPageWithSameIdentifier()
    {
        $pageStructure = new PageStructure([
            'ID' => 1,
            'name' => 'Page 1',
            'uri' => '/my-page',
            'identifier' => 'my-page'
        ]);

        $this->repository->createPage($pageStructure);

        $pageStructure2 = new PageStructure([
            'ID' => 2,
            'name' => 'Page 2',
            'uri' => '/page-2',
            'identifier' => 'my-page-2'
        ]);

        $this->repository->createPage($pageStructure2);

        $pageStructure2Updated = new PageStructure([
            'identifier' => 'my-page'
        ]);

        $this->interactor->run(2, $pageStructure2Updated);
    }

    public function testUpdatePage()
    {
        $this->createSamplePage();

        $pageStructureUpdated = new PageStructure([
            'name' => 'Test page updated',
            'uri' => '/test-page',
            'identifier' => 'test-page'
        ]);

        $this->interactor->run(1, $pageStructureUpdated);

        $page = $this->repository->findByID(1);

        $this->assertEquals('Test page updated', $page->getName());
        $this->assertEquals('/test-page', $page->getURI());
        $this->assertEquals('test-page', $page->getIdentifier());
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
 