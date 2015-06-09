<?php

use CMS\Context;
use CMS\Entities\Page;
use CMS\Interactors\Areas\CreateAreaInteractor;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\Interactors\Pages\UpdatePageInteractor;
use CMS\Structures\AreaStructure;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\PageStructure;

class UpdatePageInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new UpdatePageInteractor();
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

        Context::getRepository('page')->createPage($pageStructure);

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

        Context::getRepository('page')->createPage($pageStructure);

        $pageStructure2 = new PageStructure([
            'ID' => 2,
            'name' => 'Page 2',
            'uri' => '/page-2',
            'identifier' => 'page-2'
        ]);

        Context::getRepository('page')->createPage($pageStructure2);

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

        Context::getRepository('page')->createPage($pageStructure);

        $pageStructure2 = new PageStructure([
            'ID' => 2,
            'name' => 'Page 2',
            'uri' => '/page-2',
            'identifier' => 'my-page-2'
        ]);

        Context::getRepository('page')->createPage($pageStructure2);

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

        $page = Context::getRepository('page')->findByID(1);

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
        Context::getRepository('page')->createPage($page);
    }

    public function testUpdatePageToMaster()
    {
        $this->createSamplePage();

        $area = new AreaStructure([
            'ID' => 1,
            'page_id' => 1,
            'name' => 'Test area'
        ]);

        (new CreateAreaInteractor())->run($area);

        $block = new HTMLBlockStructure([
            'ID' => 1,
            'area_id' => 1,
            'name' => 'Test block'
        ]);

        (new CreateBlockInteractor())->run($block);

        $pageStructure = new PageStructure([
            'is_master' => 1
        ]);
        $this->interactor->run(1, $pageStructure);

        $area = Context::getRepository('area')->findByID(1);
        $this->assertEquals(1, $area->getIsMaster());

        $block = Context::getRepository('block')->findByID(1);
        $this->assertEquals(1, $block->getIsMaster());
    }
}
