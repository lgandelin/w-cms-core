<?php

namespace CMS\Repositories;

use CMS\Structures\PageStructure;

interface PageRepositoryInterface {

    public function findByID($pageID);
    public function findByUri($pageUri);
    public function findByIdentifier($pageIdentifier);
    public function findAll();
    public function createPage(PageStructure $pageStructure);
    public function updatePage($pageID, PageStructure $pageStructure);
    public function deletePage($pageID);
    
}