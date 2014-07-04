<?php

use CMS\Interactors\Pages\CreatePageInteractor;
use CMS\Interactors\Pages\GetAllPagesInteractor;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\PageStructure;

class GetAllPagesInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->pageRepository = new InMemoryPageRepository();
        $this->interactor = new GetAllPagesInteractor($this->pageRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Pages\GetAllPagesInteractor', $this->interactor);
    }

    public function testGetAllWithoutPages()
    {
        $this->assertCount(0, $this->interactor->getAll());
    }

    public function testGetAll()
    {
        $pageStructure = new PageStructure([
            'uri' => '/home',
            'identifier' => 'home',
            'name' => 'Home page'
        ]);

        $pageStructure2 = new PageStructure([
            'uri' => '/home',
            'identifier' => 'home',
            'name' => 'Home page'
        ]);

        $this->pageRepository->createPage($pageStructure);
        $this->pageRepository->createPage($pageStructure2);


        $this->assertCount(2, $this->interactor->getAll());
    }

}
 