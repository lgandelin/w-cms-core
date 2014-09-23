<?php

use CMS\Converters\MenuConverter;
use CMS\Interactors\Menus\AddMenuItemInteractor;
use CMS\Interactors\Menus\DeleteMenuItemInteractor;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Repositories\InMemory\InMemoryMenuRepository;
use CMS\Repositories\InMemory\InMemoryPageRepository;
use CMS\Structures\MenuItemStructure;
use CMS\Structures\MenuStructure;

class DeleteMenuItemInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;

    public function setUp()
    {
        $this->repository = new InMemoryMenuRepository();
        $this->interactor = new DeleteMenuItemInteractor($this->repository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Menus\DeleteMenuItemInteractor', $this->interactor);
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteMenuItemFromNonExistingMenu()
    {
        $this->interactor->run(1, 2);
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingMenuItem()
    {
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Main menu',
            'identifier' => 'main-menu'
        ]);

        $this->repository->createMenu($menuStructure);

        $this->interactor->run(1, 2);
    }

    public function testDeleteItem()
    {
        $menuStructure = new MenuStructure([
            'ID' => 1,
            'name' => 'Main menu',
            'identifier' => 'main-menu'
        ]);

        $menuItemStructure = new MenuItemStructure([
            'ID' => 1,
            'label' => 'Menu Item',
            'page' => null,
            'order' => 1
        ]);

        $this->repository->createMenu($menuStructure);

        //Add the item
        $interactor = new AddMenuItemInteractor($this->repository, new InMemoryPageRepository());
        $interactor->run(1, $menuItemStructure);

        $this->assertEquals(1, $this->getItemsNumber(1));

        //Delete the item
        $this->interactor->run(1, 1);

        $this->assertEquals(0, $this->getItemsNumber(1));

    }

    public function getItemsNumber($menuID)
    {
        $menuStructure = $this->repository->findByID($menuID);
        $menu = MenuConverter::convertMenuStructureToMenu($menuStructure);

        return sizeof($menu->getItems());
    }

}
 