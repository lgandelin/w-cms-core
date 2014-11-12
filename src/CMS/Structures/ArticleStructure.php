<?php

namespace CMS\Structures;

use CMS\Entities\Article;

class ArticleStructure extends DataStructure
{
    public $ID;
    public $title;
    public $summary;
    public $text;
    public $author_id;
    public $publication_date;

    public static function toStructure(Article $article)
    {
        $articleStructure = new ArticleStructure();
        $articleStructure->ID = $article->getID();
        $articleStructure->title = $article->getTitle();
        $articleStructure->summary = $article->getSummary();
        $articleStructure->text = $article->getText();
        $articleStructure->author_id = $article->getAuthorID();
        $articleStructure->publication_date = $article->getPublicationDate();

        return $articleStructure;
    }
}
