<?php

namespace CMS\Entities;

class ArticleCategory extends Entity
{
    private $ID;
    private $name;
    private $description;
    private $langID;

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

    public function setlangID($lang_id)
    {
        $this->langID = $lang_id;
    }

    public function getlangID()
    {
        return $this->langID;
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
        if (!$this->getName()) {
            throw new \InvalidArgumentException('You must provide a name for a category');
        }

        return true;
    }
}
