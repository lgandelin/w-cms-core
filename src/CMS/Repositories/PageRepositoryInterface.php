<?php

namespace CMS\Repositories;

use CMS\Entities\Page;

interface PageRepositoryInterface {

    public function findByID($pageID);
    public function findByUri($pageUri);
    public function findByIdentifier($pageIdentifier);
    public function findAll();
    public function createPage(Page $page);
    public function updatePage(Page $page);
    public function deletePage($pageID);
    
}