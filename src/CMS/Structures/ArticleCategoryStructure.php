<?php

namespace CMS\Structures;

use CMS\Entities\ArticleCategory;

class ArticleCategoryStructure extends DataStructure
{
    public $ID;
    public $name;
    public $description;

    public static function toStructure(ArticleCategory $article)
    {
        $articleStructure = new ArticleCategoryStructure();
        $articleStructure->ID = $article->getID();
        $articleStructure->name = $article->getName();
        $articleStructure->description = $article->getDescription();

        return $articleStructure;
    }
}