<?php

use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\PageStructure;

class GetPageInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->pageRepository = new InMemoryPageRepository();
        $this->interactor = new GetPageInteractor($this->pageRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Pages\GetPageInteractor', $this->interactor);
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingPage()
    {
        $this->interactor->getByID(1);
    }
}
 