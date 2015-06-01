<?php

use CMS\Context;
use CMS\Entities\Page;
use CMS\Interactors\Pages\GetPageInteractor;

class GetPageInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetPageInteractor();
    }
    
    /**
     * @expectedException Exception
     */
    public function testGetNonExistingPage()
    {
        $this->interactor->getPageByID(1);
    }

    public function testGetPageByURI()
    {
        $this->createSamplePage();

        $page = $this->interactor->getPageByURI('/test-page');

        $this->assertEquals('Test page', $page->getName());
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setName('Test page');
        $page->setIdentifier('test-page');
        $page->setURI('/test-page');

        Context::$pageRepository->createPage($page);
    }
}
