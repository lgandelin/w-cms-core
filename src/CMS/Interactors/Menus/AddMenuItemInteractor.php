<?php

namespace CMS\Interactors\Menus;

use CMS\Converters\MenuConverter;
use CMS\Converters\MenuItemConverter;
use CMS\Converters\PageConverter;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Repositories\MenuRepositoryInterface;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\MenuItemStructure;
use CMS\UseCases\Menus\AddMenuItemUseCase;

class AddMenuItemInteractor extends GetMenuInteractor implements AddMenuItemUseCase
{
    private $pageRepository;

    public function __construct(MenuRepositoryInterface $repository, PageRepositoryInterface $pageRepository)
    {
        $this->repository = $repository;
        $this->pageRepository = $pageRepository;
    }

    public function run($menuID, MenuItemStructure $menuItemStructure)
    {
        if ($menuStructure = $this->getByID($menuID)) {
            $menu = MenuConverter::convertMenuStructureToMenu($menuStructure);
            $menuItem = MenuItemConverter::convertMenuItemStructureToMenuItem($menuItemStructure);

            if (isset($menuItemStructure->page_id) && $menuItemStructure->page_id !== null) {
                if ($page = $this->getPageByID($menuItemStructure->page_id))
                    $menuItem->setPage(PageConverter::convertPageStructureToPage($page));
            }

            if ($menuItem->valid()) {
                $menu->addItem($menuItem);
                return $this->repository->addItem($menuID, MenuItemConverter::convertMenuItemToMenuItemStructure($menuItem));
            }
        }
    }

    private function getPageByID($pageID)
    {
        $interactor = new GetPageInteractor($this->pageRepository);

        return $interactor->getByID($pageID);
    }
} 