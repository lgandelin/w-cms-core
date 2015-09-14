<?php

namespace Webaccess\WCMSCore\Entities\Blocks;

use Webaccess\WCMSCore\Entities\Block;

class ControllerBlock extends Block
{
    private $classPath;
    private $method;

    public function setClassPath($classPath)
    {
        $this->classPath = $classPath;
    }

    public function getClassPath()
    {
        return $this->classPath;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getContentData()
    {
        if ($this->getClassPath() && $this->getMethod()) {
            $class = $this->getClassPath();
            $method = $this->getMethod();
            $controller = new $class();

            return $controller->$method();;
        }

        return null;
    }
}
