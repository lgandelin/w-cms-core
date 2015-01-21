<?php

namespace CMS\Entities;

class Media
{
    private $ID;
    private $name;
    private $path;

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

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function valid()
    {
        if (!$this->getName()) {
            throw new \InvalidArgumentException('You must provide a name for a media');
        }

        return true;
    }

} 