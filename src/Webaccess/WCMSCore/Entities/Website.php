<?php

namespace Webaccess\WCMSCore\Entities;

class Website
{
    private $name;
    private $url;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getName()
    {
        return $this->name;
    }
}
