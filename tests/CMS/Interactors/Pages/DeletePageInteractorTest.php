<?php

use CMS\Interactors\Pages\DeletePageInteractor;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\PageStructure;

class DeletePageInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->pageRepository = new InMemoryPageRepository();
        $this->interactor = new DeletePageInteractor($this->pageRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Pages\DeletePageInteractor', $this->interactor);
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingPage()
    {
        $pageStructure = new PageStructure([
            'ID' => 1,
            'name' => 'Home page',
            'uri' => '/',
            'identifier' => 'home'
        ]);

        $this->pageRepository->createPage($pageStructure);
        $this->assertCount(1, $this->pageRepository->findAll());

        $this->interactor->run(2);
    }

    public function testDelete()
    {
        $pageStructure = new PageStructure([
            'ID' => 1,
            'name' => 'Home page',
            'uri' => '/',
            'identifier' => 'home'
        ]);

        $this->pageRepository->createPage($pageStructure);

        $this->assertCount(1, $this->pageRepository->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, $this->pageRepository->findAll());
    }
}
 