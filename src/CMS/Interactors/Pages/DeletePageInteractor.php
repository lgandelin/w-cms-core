<?php

namespace CMS\Interactors\Pages;

class DeletePageInteractor extends GetPageInteractor
{
    public function run($pageID)
    {
        if ($this->getByID($pageID))
            $this->pageRepository->deletePage($pageID);
    }

}