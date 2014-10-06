<?php

namespace CMS\Interactors\Menus;

use CMS\Converters\MenuConverter;
use CMS\Converters\MenuItemConverter;
use CMS\Converters\PageConverter;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Repositories\MenuRepositoryInterface;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\MenuItemStructure;

class UpdateMenuItemInteractor extends GetMenuInteractor {

    private $pageRepository;

    public function __construct(MenuRepositoryInterface $repository, PageRepositoryInterface $pageRepository)
    {
        parent::__construct($repository);
        $this->pageRepository = $pageRepository;
    }

    public function run($menuID, $menuItemID, MenuItemStructure $menuItemStructure)
    {
        if ($menuStructure = $this->getByID($menuID)) {
            $menu = MenuConverter::convertMenuStructureToMenu($menuStructure);

            if ($originalMenuItemStructure = $this->getMenuItemByID($menuID, $menuItemID)) {

                $menuItemUpdated = $this->getMenuItemUpdated($originalMenuItemStructure, $menuItemStructure);
                $menu->updateItem($menuItemID, $menuItemUpdated);
                $this->repository->updateItem($menuID, $menuItemID, MenuItemConverter::convertMenuItemToMenuItemStructure($menuItemUpdated));
            }
        }
    }

    public function getMenuItemUpdated($originalMenuItemStructure, $menuItemStructure)
    {
        $menuItem = MenuItemConverter::convertMenuItemStructureToMenuItem($originalMenuItemStructure);

        if (isset($menuItemStructure->label) && $menuItemStructure->label !== null && $menuItem->getLabel() != $menuItemStructure->label) $menuItem->setLabel($menuItemStructure->label);
        if (isset($menuItemStructure->order) && $menuItemStructure->order !== null && $menuItem->getOrder() != $menuItemStructure->order) $menuItem->setOrder($menuItemStructure->order);

        if (isset($menuItemStructure->page_id) && $menuItemStructure->page_id !== null) {
            $getPageInteractor = new GetPageInteractor($this->pageRepository);
            $page = PageConverter::convertPageStructureToPage($getPageInteractor->getByID($menuItemStructure->page_id));

            $menuItem->setPage($page);
        }

        return $menuItem;
    }

}