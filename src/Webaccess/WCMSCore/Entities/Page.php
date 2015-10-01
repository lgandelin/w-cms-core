<?php

namespace Webaccess\WCMSCore\Entities;

class Page extends Entity
{
    private $ID;
    private $name;
    private $identifier;
    private $uri;
    private $langID;
    private $meta_title;
    private $meta_description;
    private $meta_keywords;
    private $is_visible;
    private $is_indexed;
    private $is_master;
    private $master_page_id;
    private $version_number;
    private $draft_version_number;

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

    public function setLangID($lang_id)
    {
        $this->langID = $lang_id;
    }

    public function getLangID()
    {
        return $this->langID;
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

    public function setIsIndexed($is_indexed)
    {
        $this->is_indexed = $is_indexed;
    }

    public function setIsVisible($is_visible)
    {
        $this->is_visible = $is_visible;
    }

    public function getIsVisible()
    {
        return $this->is_visible;
    }

    public function getIsIndexed()
    {
        return $this->is_indexed;
    }

    public function setIsMaster($is_master)
    {
        $this->is_master = $is_master;
    }

    public function getIsMaster()
    {
        return $this->is_master;
    }

    public function setMasterPageId($master_page_id)
    {
        $this->master_page_id = $master_page_id;
    }

    public function getMasterPageId()
    {
        return $this->master_page_id;
    }

    public function getVersionNumber()
    {
        return $this->version_number;
    }

    public function setVersionNumber($versionNumber)
    {
        $this->version_number = $versionNumber;
    }

    public function setDraftVersionNumber($draft_version_number)
    {
        $this->draft_version_number = $draft_version_number;
    }

    public function getDraftVersionNumber()
    {
        return $this->draft_version_number;
    }

    public function valid()
    {
        if (!$this->getUri()) {
            throw new \InvalidArgumentException('You must provide a URI for a page');
        }

        if (!$this->getIdentifier()) {
            throw new \InvalidArgumentException('You must provide an identifier for a page');
        }

        if (!$this->getVersionNumber()) {
            $this->setVersionNumber(1);
        }

        if (!$this->getDraftVersionNumber()) {
            $this->setDraftVersionNumber(1);
        }

        return true;
    }
}
