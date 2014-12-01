<?php

namespace CMS\Structures;

use CMS\Entities\Page;

class PageStructure extends DataStructure
{
    public $ID;
    public $name;
    public $uri;
    public $identifier;
    public $website;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;

    public static function toStructure(Page $page)
    {
        $pageStructure = new PageStructure();
        $pageStructure->ID = $page->getID();
        $pageStructure->name = $page->getName();
        $pageStructure->uri = $page->getURI();
        $pageStructure->identifier = $page->getIdentifier();
        $pageStructure->identifier = $page->getIdentifier();
        $pageStructure->meta_title = $page->getMetaTitle();
        $pageStructure->meta_description = $page->getMetaDescription();
        $pageStructure->meta_keywords = $page->getMetaKeywords();

        return $pageStructure;
    }
}
