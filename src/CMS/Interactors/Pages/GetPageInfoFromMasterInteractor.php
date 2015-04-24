<?php

namespace CMS\Interactors\Pages;

class GetPageInfoFromMasterInteractor
{
    private $getPageInteractor;

    public function __construct(GetPageInteractor $getPageInteractor)
    {
        $this->getPageInteractor = $getPageInteractor;
    }

    public function getPageStructure($masterPageID, $pageTitle)
    {
        $pageStructure = \App::make('GetPageInteractor')->getPageByID($masterPageID, true);
        $pageStructure->name = $pageTitle;
        $slug = strtolower(str_replace(' ', '-', $pageTitle));
        $pageStructure->uri = '/' . $slug;
        $pageStructure->identifier = $slug;
        $pageStructure->is_master = 0;
        $pageStructure->master_page_id = $masterPageID;

        return $pageStructure;
    }
}
