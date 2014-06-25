<?php

namespace CMS\Structures;

use CMS\Entities\Page;
use CMS\Structures\DataStructure;

class PageStructure extends DataStructure {

    public $name;
    public $uri;
    public $identifier;
    public $text;
    public $website;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;

    public static function convertPageToPageStructure(Page $page)
    {
        return new PageStructure([
            'identifier' => $page->getIdentifier(),
            'name' => $page->getName(),
            'uri' => $page->getUri(),
            'text' => $page->getText(),
            'meta_title' => $page->getMetaTitle(),
            'meta_description' => $page->getMetaDescription(),
            'meta_keywords' => $page->getMetaKeywords()
        ]);
    }

    public static function convertPageStructureToPage(PageStructure $pageStructure)
    {
        $page = new Page();
        $page->setIdentifier($pageStructure->identifier);
        $page->setName($pageStructure->name);
        $page->setUri($pageStructure->uri);
        $page->setText($pageStructure->text);
        $page->setMetaTitle($pageStructure->meta_title);
        $page->setMetaDescription($pageStructure->meta_description);
        $page->setMetaKeywords($pageStructure->meta_keywords);

        return $page;
    }
} 