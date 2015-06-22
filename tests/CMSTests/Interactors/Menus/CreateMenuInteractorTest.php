<?php

use CMS\Context;
use CMS\Interactors\Menus\CreateMenuInteractor;
use CMS\DataStructure;

class CreateMenuInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateMenuInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testCreateMenuWithoutIdentifier()
    {
        $menuStructure = new DataStructure([
            'name' => 'Menu'
        ]);

        $this->interactor->run($menuStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateMenuWithAnotherExistingMenuWithSameIdentifier()
    {
        $menuStructure = new DataStructure([
            'name' => 'Menu 1',
            'identifier' => 'my-menu',
        ]);

        $this->interactor->run($menuStructure);

        $menuStructure = new DataStructure([
            'name' => 'Menu 2',
            'identifier' => 'my-menu',
        ]);

        $this->interactor->run($menuStructure);
    }

    public function testCreateMenu()
    {
        $this->assertCount(0, Context::getRepository('menu')->findAll());

        $menuStructure = new DataStructure([
            'name' => 'Main menu',
            'identifier' => 'main-menu'
        ]);

        $this->interactor->run($menuStructure);

        $this->assertCount(1, Context::getRepository('menu')->findAll());
    }
}
