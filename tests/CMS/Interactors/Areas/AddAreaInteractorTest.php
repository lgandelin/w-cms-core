<?php

use CMS\Interactors\Areas\AddAreaInteractor;
use CMS\Repositories\InMemory\InMemoryAreaRepository;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\AreaStructure;
use CMS\Structures\PageStructure;

class AddAreaInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->repository = new InMemoryAreaRepository();
        $this->pageRepository = new InMemoryPageRepository();
        $this->interactor = new AddAreaInteractor($this->repository, $this->pageRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Areas\AddAreaInteractor', $this->interactor);
    }

    /**
     * @expectedException Exception
     */
    public function testAddAreaToNonExistingPage()
    {
        $areaStructure = new AreaStructure([
            'ID' => 1,
            'name' => 'Area 1'
        ]);

        $this->interactor->run(1, $areaStructure);
    }

    public function testAddArea()
    {
        $pageStructure = new PageStructure([
            'ID' => 1,
            'name' => 'Home page',
            'uri' => '/',
            'identifier' => 'home'
        ]);

        $this->pageRepository->createPage($pageStructure);

        $areaStructure = new AreaStructure([
            'ID' => 1,
            'name' => 'Area 1',
            'page_id' => 1
        ]);

        $this->interactor->run(1, $areaStructure);

        $this->assertEquals(1, count($this->repository->findByPageID(1)));
    }

}
 