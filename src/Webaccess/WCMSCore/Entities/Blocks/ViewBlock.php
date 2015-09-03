<?php

namespace Webaccess\WCMSCore\Entities\Blocks;

use Webaccess\WCMSCore\Entities\Block;

class ViewBlock extends Block
{
    private $viewPath;

    public function setViewPath($viewPath)
    {
        $this->viewPath = $viewPath;
    }

    public function getViewPath()
    {
        return $this->viewPath;
    }

    public function getContentData()
    {
        if ($this->getViewPath()) {
            $content = new \StdClass();
            $content->view_path = $this->getViewPath();

            return $content;
        }

        return null;
    }
}
