<?php

namespace CMS\Interactors\Pages;

use CMS\Context;
use CMS\Entities\Page;
use CMS\Structures\PageStructure;

class CreatePageInteractor
{
    public function run(PageStructure $pageStructure)
    {
        $page = new Page();
        $page->setInfos($pageStructure);
        $page->valid();

        if ($this->anotherExistingPageWithSameUri($page->getUri())) {
            throw new \Exception('There is already a page with the same URI');
        }

        if ($this->anotherExistingPageWithSameIdentifier($page->getIdentifier())) {
            throw new \Exception('There is already a page with the same identifier');
        }

        return Context::$pageRepository->createPage($page);
    }

    private function anotherExistingPageWithSameIdentifier($identifier)
    {
        return Context::$pageRepository->findByIdentifier($identifier);
    }

    private function anotherExistingPageWithSameUri($uri)
    {
        return Context::$pageRepository->findByUri($uri);
    }
}
