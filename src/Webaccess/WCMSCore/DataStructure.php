<?php

namespace Webaccess\WCMSCore;

class DataStructure
{
    public function __construct($parameters = array())
    {
        foreach ($parameters as $key => $value) {
            $this->$key = $value;
        }
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
