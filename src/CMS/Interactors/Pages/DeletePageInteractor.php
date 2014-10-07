<?php

namespace CMS\Interactors\Pages;

class DeletePageInteractor extends GetPageInteractor
{
    public function run($pageID)
    {
        if ($this->getPageByID($pageID))
            $this->repository->deletePage($pageID);
    }
}