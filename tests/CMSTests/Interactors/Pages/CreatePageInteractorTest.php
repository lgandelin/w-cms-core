<?php

use CMS\Context;
use CMS\Interactors\Pages\CreatePageInteractor;
use CMS\DataStructure;

class CreatePageInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreatePageInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testCreatePageWithoutUri()
    {
        $page = new DataStructure([
            'name' => 'Page',
            'identifier' => 'page'
        ]);

        $this->interactor->run($page);
    }

    /**
     * @expectedException Exception
     */
    public function testCreatePageWithoutIdentifier()
    {
        $pageStructure = new DataStructure([
            'name' => 'Page',
            'uri' => 'page'
        ]);

        $this->interactor->run($pageStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testCreatePageWithAnotherExistingPageWithSameUri()
    {
        $pageStructure = new DataStructure([
            'uri' => '/home',
            'identifier' => 'home',
            'name' => 'Home page'
        ]);

        $this->interactor->run($pageStructure);

        $pageStructure = new DataStructure([
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
        $pageStructure = new DataStructure([
            'uri' => '/home',
            'identifier' => 'home',
            'name' => 'Home page'
        ]);

        $this->interactor->run($pageStructure);

        $pageStructure = new DataStructure([
            'uri' => '/home-new',
            'identifier' => 'home',
            'name' => 'Home page new'
        ]);

        $this->interactor->run($pageStructure);
    }

    public function testCreatePage()
    {
        $this->assertCount(0, Context::getRepository('page')->findAll());

        $pageStructure = new DataStructure([
            'uri' => '/home',
            'identifier' => 'home',
            'name' => 'Home page'
        ]);

        $this->interactor->run($pageStructure);

        $this->assertCount(1, Context::getRepository('page')->findAll());
    }
}
