<?php

namespace CMS\Interactors\Pages;

use CMS\UseCases\Pages\DeletePageUseCase;

class DeletePageInteractor extends GetPageInteractor implements DeletePageUseCase
{
    public function run($pageID)
    {
        if ($this->getByID($pageID))
            $this->pageRepository->deletePage($pageID);
    }

}