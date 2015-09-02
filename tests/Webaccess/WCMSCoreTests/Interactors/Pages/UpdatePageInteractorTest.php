<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Interactors\Areas\CreateAreaInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\CreateBlockInteractor;
use Webaccess\WCMSCore\Interactors\Pages\UpdatePageInteractor;
use Webaccess\WCMSCore\DataStructure;

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
        $pageStructure = new DataStructure([
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
        $pageStructure = new DataStructure([
            'ID' => 1,
            'name' => 'Page',
            'uri' => ''
        ]);

        Context::get('page')->createPage($pageStructure);

        $this->interactor->run(1, $pageStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdatePageWithAlreadyExistingPageWithSameURI()
    {
        $pageStructure = new DataStructure([
            'ID' => 1,
            'name' => 'Page 1',
            'uri' => '/my-page',
            'identifier' => 'page-1'
        ]);

        Context::get('page')->createPage($pageStructure);

        $pageStructure2 = new DataStructure([
            'ID' => 2,
            'name' => 'Page 2',
            'uri' => '/page-2',
            'identifier' => 'page-2'
        ]);

        Context::get('page')->createPage($pageStructure2);

        $pageStructure2Updated = new DataStructure([
           'uri' => '/my-page'
        ]);

        $this->interactor->run(2, $pageStructure2Updated);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdatePageWithAlreadyExistingPageWithSameIdentifier()
    {
        $pageStructure = new DataStructure([
            'ID' => 1,
            'name' => 'Page 1',
            'uri' => '/my-page',
            'identifier' => 'my-page'
        ]);

        Context::get('page')->createPage($pageStructure);

        $pageStructure2 = new DataStructure([
            'ID' => 2,
            'name' => 'Page 2',
            'uri' => '/page-2',
            'identifier' => 'my-page-2'
        ]);

        Context::get('page')->createPage($pageStructure2);

        $pageStructure2Updated = new DataStructure([
            'identifier' => 'my-page'
        ]);

        $this->interactor->run(2, $pageStructure2Updated);
    }

    public function testUpdatePage()
    {
        $this->createSamplePage();

        $pageStructureUpdated = new DataStructure([
            'name' => 'Test page updated',
            'uri' => '/test-page',
            'identifier' => 'test-page'
        ]);

        $this->interactor->run(1, $pageStructureUpdated);

        $page = Context::get('page')->findByID(1);

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
        Context::get('page')->createPage($page);
    }

    public function testUpdatePageToMaster()
    {
        $this->createSamplePage();

        $area = new DataStructure([
            'ID' => 1,
            'page_id' => 1,
            'name' => 'Test area'
        ]);

        (new CreateAreaInteractor())->run($area);

        $block = new DataStructure([
            'ID' => 1,
            'area_id' => 1,
            'name' => 'Test block'
        ]);

        (new CreateBlockInteractor())->run($block);

        $pageStructure = new DataStructure([
            'is_master' => 1
        ]);
        $this->interactor->run(1, $pageStructure);

        $area = Context::get('area')->findByID(1);
        $this->assertEquals(1, $area->getIsMaster());

        $block = Context::get('block')->findByID(1);
        $this->assertEquals(1, $block->getIsMaster());
    }
}
