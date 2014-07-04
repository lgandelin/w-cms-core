<?php

use CMS\Interactors\Pages\DuplicatePageInteractor;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\PageStructure;

class DuplicatePageInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->pageRepository = new InMemoryPageRepository();
        $this->interactor = new DuplicatePageInteractor($this->pageRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Pages\DuplicatePageInteractor', $this->interactor);
    }

    /**
     * @expectedException Exception
     */
    public function testDuplicateNonExistingPage()
    {
        $this->interactor->run(2);
    }

    public function testDuplicatePage()
    {
        $pageStructure = new PageStructure([
            'ID' => 1,
            'name' => 'My page',
            'uri' => '/my-page',
            'identifier' => 'my-page'
        ]);

        $this->pageRepository->createPage($pageStructure);
        $this->assertCount(1, $this->pageRepository->findAll());

        $this->interactor->run(1);

        $this->assertCount(2, $this->pageRepository->findAll());
        $pageStructureDuplicated = $this->pageRepository->findByIdentifier('my-page-copy');
        $this->assertInstanceOf('\CMS\Structures\PageStructure', $pageStructureDuplicated);

        $this->assertEquals($pageStructureDuplicated->name, 'My page - COPY');
        $this->assertEquals($pageStructureDuplicated->uri, '/my-page-copy');
        $this->assertEquals($pageStructureDuplicated->identifier, 'my-page-copy');

    }
}
 