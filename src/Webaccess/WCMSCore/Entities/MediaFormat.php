<?php

namespace Webaccess\WCMSCore\Entities;

class MediaFormat extends Entity
{
    private $ID;
    private $name;
    private $width;
    private $height;
    private $preserveRatio;

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getID()
    {
        return $this->ID;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setPreserveRatio($preserveRatio)
    {
        $this->preserveRatio = $preserveRatio;
    }

    public function getPreserveRatio()
    {
        return $this->preserveRatio;
    }

    public function valid()
    {
        return true;
    }
}
