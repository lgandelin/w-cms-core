<?php

class MenuManagerTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->menuRepository = Phake::mock('\CMS\Repositories\MenuRepositoryInterface');
    }

    private function _getMenuManager()
    {
        return new \CMS\Services\MenuManager($this->menuRepository);
    }

    private function _createMenuObject($identifier, $items = [], $name = null)
    {
        $menu = new \CMS\Entities\Menu();
        $menu->setIdentifier($identifier);
        foreach ($items as $item)
            $menu->addItem($item);
        $menu->setName($name);

        return $menu;
    }

    private function _createMenuItemObject($label = '', $order = 0, $page = null)
    {
        $item = new \CMS\Entities\MenuItem();
        if ($label) $item->setLabel($label);
        if ($order) $item->setOrder($order);
        if ($page) $item->setPage($page);

        return $item;
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Services\MenuManager', $this->_getMenuManager());
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
        $menuS = new \CMS\Structures\MenuStructure([
            'identifier' => 'main-menu',
            'items' => [],
            'name' => 'Main menu'
        ]);
        Phake::when($this->menuRepository)->findByIdentifier('main-menu')->thenReturn($menu);

        $this->assertInstanceOf('\CMS\Structures\MenuStructure', $this->_getMenuManager()->getByIdentifier('main-menu'));
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

        Phake::when($this->menuRepository)->findAll()->thenReturn([$menu1, $menu2]);

        $this->assertEquals([$menu1, $menu2], $this->_getMenuManager()->getAll());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateMenuWithInvalidArguments()
    {
        $invalidMenuS = new \CMS\Structures\MenuStructure([
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
        $menu2S = new \CMS\Structures\MenuStructure([
            'identifier' => 'main-menu',
            'name' => 'Menu 2'
        ]);

        Phake::when($this->menuRepository)->findByIdentifier('main-menu')->thenReturn($menu1);

        $this->_getMenuManager()->createMenu($menu2S);
    }

    public function testCreateMenu()
    {
        $item1 = $this->_createMenuItemObject('Item 1');
        $item2 = $this->_createMenuItemObject('Item 2');

        $menu1 = $this->_createMenuObject('menu-1', [$item1, $item2], 'Menu 1');
        $menu2 = $this->_createMenuObject('menu-2', [], 'Menu 2');
        $menu3S = new \CMS\Structures\MenuStructure([
            'identifier' => 'menu-3',
            'items' => [new \CMS\Structures\MenuItemStructure(['label' => 'Item 1']), new \CMS\Structures\MenuItemStructure(['label' => 'Item 2'])],
            'name' => 'Menu 3',
        ]);

        Phake::when($this->menuRepository)->findAll()
            ->thenReturn([$menu1, $menu2]);

        //Before create
        $this->assertEquals([$menu1, $menu2], $this->_getMenuManager()->getAll());

        //Create
        $menu3 = $this->_getMenuManager()->createMenu($menu3S);

        Phake::when($this->menuRepository)->findAll()
            ->thenReturn([$menu1, $menu2, $menu3]);

        //After create
        $this->assertEquals([$menu1, $menu2, $menu3], $this->_getMenuManager()->getAll());
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingMenu()
    {
        $menuS = new \CMS\Structures\MenuStructure([
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
        $menuS = new \CMS\Structures\MenuStructure([
            'identifier' => 'main-menu',
            'items' => [new \CMS\Structures\MenuItemStructure(['label' => 'Item 1']), new \CMS\Structures\MenuItemStructure(['label' => 'Item 2'])],
            'name' => 'Main menu',
        ]);

        $item1Updated = $this->_createMenuItemObject('Item 1 updated');

        $menuUpdated = $this->_createMenuObject('main-menu', [$item1Updated, $item2], 'Main menu updated');
        $menuUpdatedS = new \CMS\Structures\MenuStructure([
            'identifier' => 'main-menu',
            'items' => [new \CMS\Structures\MenuItemStructure(['label' => 'Item 1 updated']), new \CMS\Structures\MenuItemStructure(['label' => 'Item 2'])],
            'name' => 'Main menu updated',
        ]);

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

        Phake::when($this->menuRepository)->findAll()
            ->thenReturn([$menu1, $menu2])
            ->thenReturn([$menu2]);
        Phake::when($this->menuRepository)->findByIdentifier('menu-1')->thenReturn($menu1);

        //Before delete
        $this->assertEquals([$menu1, $menu2], $this->_getMenuManager()->getAll());

        //Delete
        $this->_getMenuManager()->deleteMenu('menu-1');

        //After delete
        $this->assertEquals([$menu2], $this->_getMenuManager()->getAll());
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

        Phake::when($this->menuRepository)->findByIdentifier('menu-2')->thenReturn($menu2);
        Phake::when($this->menuRepository)->findAll()
            ->thenReturn([$menu1, $menu2])
            ->thenReturn([$menu1, $menu2, $menu2Duplicate]);

        //Before duplicate
        $this->assertEquals([$menu1, $menu2], $this->_getMenuManager()->getAll());

        //Duplicate
        $this->_getMenuManager()->duplicateMenu('menu-2');

        //After duplicate
        $this->assertEquals([$menu1, $menu2, $menu2Duplicate], $this->_getMenuManager()->getAll());
    }
    
}
 