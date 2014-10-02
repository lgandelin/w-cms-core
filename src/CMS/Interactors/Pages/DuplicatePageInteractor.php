<?php

namespace CMS\Interactors\Pages;

use CMS\UseCases\Pages\DuplicatePageUseCase;

class DuplicatePageInteractor extends GetPageInteractor implements DuplicatePageUseCase
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