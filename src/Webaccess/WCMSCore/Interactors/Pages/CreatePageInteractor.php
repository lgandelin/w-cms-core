<?php

namespace Webaccess\WCMSCore\Interactors\Pages;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\DataStructure;

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

        return Context::get('page_repository')->createPage($page);
    }

    private function anotherExistingPageWithSameIdentifier($identifier)
    {
        return Context::get('page_repository')->findByIdentifier($identifier);
    }

    private function anotherExistingPageWithSameUri($uri)
    {
        return Context::get('page_repository')->findByUri($uri);
    }
}
