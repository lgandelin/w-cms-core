<?php

namespace Webaccess\WCMSCore\Entities;

class Version extends Entity
{
    private $ID;
    private $number;
    private $pageID;
    private $updatedDate;

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getID()
    {
        return $this->ID;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setPageID($pageID)
    {
        $this->pageID = $pageID;
    }

    public function getPageID()
    {
        return $this->pageID;
    }

    public function setUpdatedDate($updatedDate)
    {
        $this->updatedDate = $updatedDate;
    }

    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }
}