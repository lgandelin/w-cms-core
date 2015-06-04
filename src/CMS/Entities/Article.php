<?php

namespace CMS\Entities;

class Article extends Entity
{
    private $ID;
    private $title;
    private $summary;
    private $text;
    private $langID;
    private $categoryID;
    private $authorID;
    private $pageID;
    private $mediaID;
    private $publicationDate;

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getID()
    {
        return $this->ID;
    }

    public function setAuthorID($authorID)
    {
        $this->authorID = $authorID;
    }

    public function getAuthorID()
    {
        return $this->authorID;
    }

    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    public function getSummary()
    {
        return $this->summary;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setlangID($lang_id)
    {
        $this->langID = $lang_id;
    }

    public function getlangID()
    {
        return $this->langID;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function valid()
    {
        if (!$this->getTitle()) {
            throw new \InvalidArgumentException('You must provide a title for an article');
        }

        return true;
    }

    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    }

    public function getCategoryID()
    {
        return $this->categoryID;
    }

    public function setCategoryID($categoryID)
    {
        $this->categoryID = $categoryID;
    }

    public function setPageID($pageID)
    {
        $this->pageID = $pageID;
    }

    public function getPageID()
    {
        return $this->pageID;
    }

    public function setMediaID($mediaID)
    {
        $this->mediaID = $mediaID;
    }

    public function getMediaID()
    {
        return $this->mediaID;
    }
}
