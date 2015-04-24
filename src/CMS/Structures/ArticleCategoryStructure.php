<?php

namespace CMS\Structures;

use CMS\Entities\ArticleCategory;

class ArticleCategoryStructure extends DataStructure
{
    public $ID;
    public $name;
    public $description;
    public $lang_id;

    public static function toStructure(ArticleCategory $article)
    {
        $articleStructure = new ArticleCategoryStructure();
        $articleStructure->ID = $article->getID();
        $articleStructure->name = $article->getName();
        $articleStructure->description = $article->getDescription();
        $articleStructure->lang_id = $article->getLangID();

        return $articleStructure;
    }
}
