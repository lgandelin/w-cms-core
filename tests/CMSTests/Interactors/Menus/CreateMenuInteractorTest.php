<?php

use CMS\Context;
use CMS\Interactors\Menus\CreateMenuInteractor;
use CMS\Structures\MenuStructure;

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
        $menuStructure = new MenuStructure([
            'name' => 'Menu'
        ]);

        $this->interactor->run($menuStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateMenuWithAnotherExistingMenuWithSameIdentifier()
    {
        $menuStructure = new MenuStructure([
            'name' => 'Menu 1',
            'identifier' => 'my-menu',
        ]);

        $this->interactor->run($menuStructure);

        $menuStructure = new MenuStructure([
            'name' => 'Menu 2',
            'identifier' => 'my-menu',
        ]);

        $this->interactor->run($menuStructure);
    }

    public function testCreateMenu()
    {
        $this->assertCount(0, Context::$menuRepository->findAll());

        $menuStructure = new MenuStructure([
            'name' => 'Main menu',
            'identifier' => 'main-menu'
        ]);

        $this->interactor->run($menuStructure);

        $this->assertCount(1, Context::$menuRepository->findAll());
    }
}
