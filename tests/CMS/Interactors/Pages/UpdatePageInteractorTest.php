<?php

use CMS\Converters\PageConverter;
use CMS\Interactors\Pages\UpdatePageInteractor;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\PageStructure;

class UpdatePageInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->pageRepository = new InMemoryPageRepository();
        $this->interactor = new UpdatePageInteractor($this->pageRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Pages\UpdatePageInteractor', $this->interactor);
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

        $this->pageRepository->createPage($pageStructure);

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

        $this->pageRepository->createPage($pageStructure);

        $pageStructure2 = new PageStructure([
            'ID' => 2,
            'name' => 'Page 2',
            'uri' => '/page-2',
            'identifier' => 'page-2'
        ]);

        $this->pageRepository->createPage($pageStructure2);

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

        $this->pageRepository->createPage($pageStructure);

        $pageStructure2 = new PageStructure([
            'ID' => 2,
            'name' => 'Page 2',
            'uri' => '/page-2',
            'identifier' => 'my-page-2'
        ]);

        $this->pageRepository->createPage($pageStructure2);

        $pageStructure2Updated = new PageStructure([
            'identifier' => 'my-page'
        ]);

        $this->interactor->run(2, $pageStructure2Updated);
    }

    public function testUpdatePage()
    {
        $pageStructure = new PageStructure([
            'ID' => 1,
            'name' => 'Home page',
            'uri' => '/',
            'identifier' => 'home page'
        ]);

        $this->pageRepository->createPage($pageStructure);

        $pageStructureUpdated = new PageStructure([
            'name' => 'Home page updated',
            'uri' => '/home',
            'identifier' => 'home-page'
        ]);

        $this->interactor->run(1, $pageStructureUpdated);

        $pageStructure = $this->pageRepository->findByID(1);
        $page = PageConverter::convertPageStructureToPage($pageStructure);

        $this->assertEquals('Home page updated', $page->getName());
        $this->assertEquals('/home', $page->getURI());
        $this->assertEquals('home-page', $page->getIdentifier());
    }
}
 