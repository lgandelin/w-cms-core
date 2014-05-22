<?php

namespace CMS\Services;

class PageManager {

    public function __construct(\CMS\Mappers\PageMapperInterface $pageMapper)
    {
        $this->pageMapper = $pageMapper;
    }

    public function getBySlug($slug)
    {
        return $this->pageMapper->findBySlug($slug);
    }
}