<?php

namespace CMS\Interactors\Pages;

use CMS\Context;
use CMS\Entities\Page;
use CMS\Structures\DataStructure;

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

        return Context::getRepository('page')->createPage($page);
    }

    private function anotherExistingPageWithSameIdentifier($identifier)
    {
        return Context::getRepository('page')->findByIdentifier($identifier);
    }

    private function anotherExistingPageWithSameUri($uri)
    {
        return Context::getRepository('page')->findByUri($uri);
    }
}
