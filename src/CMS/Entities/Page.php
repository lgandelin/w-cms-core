<?php

namespace CMS\Entities;

class Page {

    private $ID;
    private $name;
    private $identifier;
    private $uri;
    private $text;
    private $website;
    private $meta_title;
    private $meta_description;
    private $meta_keywords;

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getID()
    {
        return $this->ID;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setWebsite(Website $website)
    {
        $this->website = $website;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function setMetaTitle($meta_title)
    {
        $this->meta_title = $meta_title;
    }

    public function getMetaTitle()
    {
        return $this->meta_title;
    }

    public function setMetaDescription($meta_description)
    {
        $this->meta_description = $meta_description;
    }

    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    public function setMetaKeywords($meta_keywords)
    {
        $this->meta_keywords = $meta_keywords;
    }

    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }

    public function valid()
    {
        if (!$this->getUri())
            throw new \InvalidArgumentException('You must provide a URI for a page');

        if (!$this->getIdentifier())
            throw new \InvalidArgumentException('You must provide an identifier for a page');

        return true;
    }
} 