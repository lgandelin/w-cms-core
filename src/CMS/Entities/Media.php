<?php

namespace CMS\Entities;

class Media
{
    private $ID;
    private $name;
    private $fileName;
    private $alt;
    private $title;

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

    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    public function getAlt()
    {
        return $this->alt;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function valid()
    {
        if (!$this->getName()) {
            throw new \InvalidArgumentException('You must provide a name for a media');
        }

        return true;
    }
}
