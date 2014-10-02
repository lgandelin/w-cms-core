<?php

namespace CMS\Interactors\Pages;

class DuplicatePageInteractor extends GetPageInteractor
{
    public function run($pageID)
    {
        if ($pageStructure = $this->getByID($pageID)) {

            $pageStructureDuplicated = clone $pageStructure;
            $pageStructureDuplicated->ID = null;
            $pageStructureDuplicated->name .= ' - COPY';
            $pageStructureDuplicated->uri .= '-copy';
            $pageStructureDuplicated->identifier .= '-copy';

            $createPageInteractor = new CreatePageInteractor($this->pageRepository);
            return $createPageInteractor->run($pageStructureDuplicated);
        }
    }

}