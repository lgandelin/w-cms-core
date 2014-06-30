<?php

use CMS\Converters\MenuConverter;
use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
use CMS\Entities\Page;
use CMS\Services\MenuManager;
use CMS\Structures\MenuStructure;
use CMS\Structures\MenuItemStructure;

class MenuManagerTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->menuRepository = Phake::mock('\CMS\Repositories\MenuRepositoryInterface');
        $this->pageRepository = Phake::mock('\CMS\Repositories\PageRepositoryInterface');
        $this->menuConverter = new MenuConverter($this->pageRepository);
    }

    private function _getMenuManager()
    {
        return new MenuManager($this->menuRepository, $this->pageRepository);
    }

    private function _createMenuObject($identifier, $items = [], $name = null)
    {
        $menu = new Menu();
        $menu->setIdentifier($identifier);
        foreach ($items as $item)
            $menu->addItem($item);
        $menu->setName($name);

        return $menu;
    }

    private function _createMenuItemObject($label = '', $order = 0, $page = null)
    {
        $item = new MenuItem();
        if ($label) $item->setLabel($label);
        if ($order) $item->setOrder($order);
        if ($page) $item->setPage($page);

        return $item;
    }

    private function _createPageObject($identifier, $name)
    {
        $page = new Page();
        $page->setIdentifier($identifier);
        $page->setName($name);

        return $page;
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('CMS\Services\MenuManager', $this->_getMenuManager());
    }

    /**
     * @expectedException Exception
     */
    public function testGetByIdentifierNonExisting()
    {
        $menu = $this->_getMenuManager()->getByIdentifier('main-menu');
    }

    public function testGetByIdentifier()
    {
        $menu = $this->_createMenuObject('main-menu', [], 'Main menu');
        $menuS = $this->menuConverter->convertMenuToMenuStructure($menu);

        Phake::when($this->menuRepository)->findByIdentifier('main-menu')->thenReturn($menu);

        $this->assertInstanceOf('CMS\Structures\MenuStructure', $this->_getMenuManager()->getByIdentifier('main-menu'));
        $this->assertEquals($menuS, $this->_getMenuManager()->getByIdentifier('main-menu'));
    }

    public function testGetAllWithoutMenu()
    {
        Phake::when($this->menuRepository)->findAll()->thenReturn(null);

        $this->assertEquals(null, $this->_getMenuManager()->getAll());
    }

    public function testGetAll()
    {
        $menu1 = $this->_createMenuObject('menu-1', [], 'Menu 1');
        $menu2 = $this->_createMenuObject('menu-2', [], 'Menu 2');
        $menu1S = $this->menuConverter->convertMenuToMenuStructure($menu1);
        $menu2S = $this->menuConverter->convertMenuToMenuStructure($menu2);

        Phake::when($this->menuRepository)->findAll()->thenReturn([$menu1, $menu2]);

        $this->assertEquals([$menu1S, $menu2S], $this->_getMenuManager()->getAll());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateMenuWithInvalidArguments()
    {
        $invalidMenuS = new MenuStructure([
            'name' => 'Menu',
        ]);

        $this->_getMenuManager()->createMenu($invalidMenuS);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateMenuWithAlreadyExistingIdentifier()
    {
        $menu1 = $this->_createMenuObject('main-menu', [], 'Menu 1');
        $menu2S = new MenuStructure([
            'identifier' => 'main-menu',
            'name' => 'Menu 2'
        ]);

        Phake::when($this->menuRepository)->findByIdentifier('main-menu')->thenReturn($menu1);

        $this->_getMenuManager()->createMenu($menu2S);
    }

    public function testCreateMenu()
    {
        $page1 = $this->_createPageObject('page-1', 'Page 1');
        $page2 = $this->_createPageObject('page-2', 'Page 2');
        $item1 = $this->_createMenuItemObject('Item 1', 1, $page1);
        $item2 = $this->_createMenuItemObject('Item 2', 2, $page2);
        $menu1 = $this->_createMenuObject('menu-1', [$item1, $item2], 'Menu 1');
        $menu2 = $this->_createMenuObject('menu-2', [], 'Menu 2');
        $menu3 = $this->_createMenuObject('menu-3', [$item1, $item2], 'Menu 3');
        $menu1S = $this->menuConverter->convertMenuToMenuStructure($menu1);
        $menu2S = $this->menuConverter->convertMenuToMenuStructure($menu2);
        $menu3S = $this->menuConverter->convertMenuToMenuStructure($menu3);

        Phake::when($this->menuRepository)->findAll()->thenReturn([$menu1, $menu2]);

        //Before create
        $this->assertEquals([$menu1S, $menu2S], $this->_getMenuManager()->getAll());

        //Create
        $this->_getMenuManager()->createMenu($menu3S);

        Phake::when($this->menuRepository)->findAll()->thenReturn([$menu1, $menu2, $menu3]);

        //After create
        $this->assertEquals([$menu1S, $menu2S, $menu3S], $this->_getMenuManager()->getAll());
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingMenu()
    {
        $menuS = new MenuStructure([
            'identifier' => 'main-menu',
            'items' => array(),
            'name' => 'Main menu',
        ]);

        $this->_getMenuManager()->updateMenu($menuS);
    }


    public function testUpdateMenu()
    {
        $item1 = $this->_createMenuItemObject('Item 1');
        $item2 = $this->_createMenuItemObject('Item 2');
        $menu = $this->_createMenuObject('main-menu', [$item1, $item2], 'Main menu');
        $menuS = $this->menuConverter->convertMenuToMenuStructure($menu);
        $item1Updated = $this->_createMenuItemObject('Item 1 updated');
        $menuUpdated = $this->_createMenuObject('main-menu', [$item1Updated, $item2], 'Main menu updated');
        $menuUpdatedS = $this->menuConverter->convertMenuToMenuStructure($menuUpdated);

        Phake::when($this->menuRepository)->findByIdentifier('main-menu')->thenReturn($menu)->thenReturn($menuUpdated);

        //Before update
        $this->assertEquals($menuS, $this->_getMenuManager()->getByIdentifier('main-menu'));

        //Update
        $this->_getMenuManager()->updateMenu($menuUpdatedS);

        //After update
        $this->assertEquals($menuUpdatedS, $this->_getMenuManager()->getByIdentifier('main-menu'));
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingMenu()
    {
        $this->_getMenuManager()->deleteMenu('my-menu');
    }

    public function testDeleteMenu()
    {
        $menu1 = $this->_createMenuObject('menu-1', [], 'Menu 1');
        $menu2 = $this->_createMenuObject('menu-2', [], 'Menu 2');
        $menu1S = $this->menuConverter->convertMenuToMenuStructure($menu1);
        $menu2S = $this->menuConverter->convertMenuToMenuStructure($menu2);

        Phake::when($this->menuRepository)->findAll()
            ->thenReturn([$menu1, $menu2])
            ->thenReturn([$menu2]);
        Phake::when($this->menuRepository)->findByIdentifier('menu-1')->thenReturn($menu1);

        //Before delete
        $this->assertEquals([$menu1S, $menu2S], $this->_getMenuManager()->getAll());

        //Delete
        $this->_getMenuManager()->deleteMenu('menu-1');

        //After delete
        $this->assertEquals([$menu2S], $this->_getMenuManager()->getAll());
    }

    /**
     * @expectedException Exception
     */
    public function testDuplicateNonExistingMenu()
    {
        $this->_getMenuManager()->duplicateMenu('my-menu');
    }

    public function testDuplicateMenu()
    {
        $menu1 = $this->_createMenuObject('menu-1', [], 'Menu 1');
        $menu2 = $this->_createMenuObject('menu-2', [], 'Menu 2');
        $menu2Duplicate = $this->_createMenuObject('menu-2-copy', [], 'Menu 2 COPY');
        $menu1S = $this->menuConverter->convertMenuToMenuStructure($menu1);
        $menu2S = $this->menuConverter->convertMenuToMenuStructure($menu2);
        $menu2DuplicateS = $this->menuConverter->convertMenuToMenuStructure($menu2Duplicate);

        Phake::when($this->menuRepository)->findByIdentifier('menu-2')->thenReturn($menu2);
        Phake::when($this->menuRepository)->findAll()
            ->thenReturn([$menu1, $menu2])
            ->thenReturn([$menu1, $menu2, $menu2Duplicate]);

        //Before duplicate
        $this->assertEquals([$menu1S, $menu2S], $this->_getMenuManager()->getAll());

        //Duplicate
        $this->_getMenuManager()->duplicateMenu('menu-2');

        //After duplicate
        $this->assertEquals([$menu1S, $menu2S, $menu2DuplicateS], $this->_getMenuManager()->getAll());
    }
    
}
 