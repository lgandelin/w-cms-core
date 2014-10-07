<?php

namespace CMS\Interactors\Pages;

class DuplicatePageInteractor extends GetPageInteractor
{
    public function run($pageID)
    {
        if ($page = $this->getPageByID($pageID, true)) {
            $pageDuplicated = clone $page;
            $pageDuplicated->id = null;
            $pageDuplicated->name = $page->name . ' - COPY';
            $pageDuplicated->uri = $page->uri . '-copy';
            $pageDuplicated->identifier = $page->identifier . '-copy';

            return $this->getCreatePageInteractor()->run($pageDuplicated);
        }
    }

    private function getCreatePageInteractor()
    {
        return new CreatePageInteractor($this->repository);
    }
}