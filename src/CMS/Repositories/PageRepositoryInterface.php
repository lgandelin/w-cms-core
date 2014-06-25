<?php

namespace CMS\Repositories;

use CMS\Entities\Page;

interface PageRepositoryInterface {

    public function findByIdentifier($identifier);
    public function findByUri($uri);
    public function findAll();
    public function createPage(Page $page);
    public function updatePage(Page $page);
    public function deletePage(Page $page);
    
}