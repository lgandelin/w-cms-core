<?php

namespace CMS\Mappers;

interface PageMapperInterface {

    public function findByIdentifier($identifier);
    public function findByUri($uri);
    public function findAll();
    public function createPage(\CMS\Entities\Page $page);
    public function updatePage(\CMS\Entities\Page $page);
    public function deletePage(\CMS\Entities\Page $page);
}