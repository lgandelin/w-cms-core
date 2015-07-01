<?php

namespace CMS\Interactors\Pages;

use CMS\Context;
use CMS\Entities\Page;
use CMS\DataStructure;

class CreatePageInteractor
{
    public function run(DataStructure $pageStructure)
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

        return Context::get('page')->createPage($page);
    }

    private function anotherExistingPageWithSameIdentifier($identifier)
    {
        return Context::get('page')->findByIdentifier($identifier);
    }

    private function anotherExistingPageWithSameUri($uri)
    {
        return Context::get('page')->findByUri($uri);
    }
}
