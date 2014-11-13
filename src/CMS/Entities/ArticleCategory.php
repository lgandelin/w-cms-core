<?php

namespace CMS\Entities;

class ArticleCategory
{
    private $ID;
    private $name;
    private $description;

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getID()
    {
        return $this->ID;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function valid()
    {
        if (!$this->getName())
            throw new \InvalidArgumentException('You must provide a name for a category');

        return true;
    }
}