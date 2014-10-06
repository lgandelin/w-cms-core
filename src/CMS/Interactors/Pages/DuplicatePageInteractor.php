<?php

namespace CMS\Interactors\Pages;

class DuplicatePageInteractor extends GetPageInteractor
{
    public function run($pageID)
    {
        if ($page = $this->getPageByID($pageID)) {

            $pageDuplicated = clone $page;
            $pageDuplicated->setID(null);
            $pageDuplicated->setName($page->getName() . ' - COPY');
            $pageDuplicated->setURI($page->getURI() . '-copy');
            $pageDuplicated->setIdentifier($page->getIdentifier() . '-copy');

            return $this->getCreatePageInteractor()->run($pageDuplicated);
        }
    }

    private function getCreatePageInteractor()
    {
        return new CreatePageInteractor($this->repository);
    }
}