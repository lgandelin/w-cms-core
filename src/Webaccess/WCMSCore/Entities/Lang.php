<?php

namespace Webaccess\WCMSCore\Entities;

class Lang extends Entity
{
    private $ID;
    private $name;
    private $prefix;
    private $code;
    private $is_default;

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

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }
    
    public function setIsDefault($is_default)
    {
        $this->is_default = $is_default;
    }

    public function getIsDefault()
    {
        return $this->is_default;
    }

    public function valid()
    {
        if (!$this->getName()) {
            throw new \Exception('You must provide a name for a lang');
        }

        return true;
    }
}
