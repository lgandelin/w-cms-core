<?php

namespace CMS\Entities;

class Article
{
    private $ID;
    private $title;
    private $summary;
    private $text;
    private $authorID;
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
        if (!$this->getTitle())
            throw new \InvalidArgumentException('You must provide a title for a content');

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
}