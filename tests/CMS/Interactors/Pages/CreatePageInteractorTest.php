<?php

use CMS\Interactors\Pages\CreatePageInteractor;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\PageStructure;

class CreatePageInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->pageRepository = new InMemoryPageRepository();
        $this->interactor = new CreatePageInteractor($this->pageRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Pages\CreatePageInteractor', $this->interactor);
    }

    /**
     * @expectedException Exception
     */
    public function testCreatePageWithoutUri()
    {
        $pageStructure = new PageStructure([

        ]);

        $this->interactor->run($pageStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testCreatePageWithAnotherExistingPageWithSameUri()
    {
        $pageStructure = new PageStructure([
            'uri' => '/home',
            'identifier' => 'home',
            'name' => 'Home page'
        ]);

        $this->interactor->run($pageStructure);

        $pageStructure = new PageStructure([
            'uri' => '/home',
            'identifier' => 'home-new',
            'name' => 'Home page new'
        ]);

        $this->interactor->run($pageStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testCreatePageWithAnotherExistingPageWithSameIdentifier()
    {
        $pageStructure = new PageStructure([
            'uri' => '/home',
            'identifier' => 'home',
            'name' => 'Home page'
        ]);

        $this->interactor->run($pageStructure);

        $pageStructure = new PageStructure([
            'uri' => '/home-new',
            'identifier' => 'home',
            'name' => 'Home page new'
        ]);

        $this->interactor->run($pageStructure);
    }

    public function testCreatePage()
    {
        $this->assertCount(0, $this->pageRepository->findAll());

        $pageStructure = new PageStructure([
            'uri' => '/home',
            'identifier' => 'home',
            'name' => 'Home page'
        ]);

        $this->interactor->run($pageStructure);

        $this->assertCount(1, $this->pageRepository->findAll());
    }
}