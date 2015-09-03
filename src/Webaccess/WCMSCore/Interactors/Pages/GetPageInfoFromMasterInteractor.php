<?php

namespace Webaccess\WCMSCore\Interactors\Pages;

class GetPageInfoFromMasterInteractor
{
    public function getDataStructure($masterPageID, $pageTitle)
    {
        $pageStructure = (new GetPageInteractor())->getPageByID($masterPageID, true);
        $pageStructure->name = $pageTitle;
        $slug = strtolower(str_replace(' ', '-', $pageTitle));
        $pageStructure->uri = '/' . $slug;
        $pageStructure->identifier = $slug;
        $pageStructure->is_master = 0;
        $pageStructure->master_page_id = $masterPageID;

        return $pageStructure;
    }
}
