<?php

namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\Page;

interface PageRepositoryInterface
{
    public function findByID($pageID);

    public function findByUri($pageUri);

    public function findByUriAndLangID($pageUri, $langID);

    public function findByIdentifier($pageIdentifier);

    public function findAll($langID = null);

    public function findMasterPages();

    public function createPage(Page $page);

    public function updatePage(Page $page);

    public function deletePage($pageID);
}
