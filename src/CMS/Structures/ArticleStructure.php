<?php

namespace CMS\Structures;

use CMS\Entities\Article;

class ArticleStructure extends DataStructure
{
    public $ID;
    public $title;
    public $summary;
    public $text;
    public $lang_id;
    public $category_id;
    public $author_id;
    public $page_id;
    public $media_id;
    public $publication_date;

    public static function toStructure(Article $article)
    {
        $articleStructure = new ArticleStructure();
        $articleStructure->ID = $article->getID();
        $articleStructure->title = $article->getTitle();
        $articleStructure->summary = $article->getSummary();
        $articleStructure->text = $article->getText();
        $articleStructure->lang_id = $article->getLangID();
        $articleStructure->category_id = $article->getCategoryID();
        $articleStructure->author_id = $article->getAuthorID();
        $articleStructure->page_id = $article->getPageID();
        $articleStructure->media_id = $article->getMediaID();
        $articleStructure->publication_date = $article->getPublicationDate();

        return $articleStructure;
    }
}
