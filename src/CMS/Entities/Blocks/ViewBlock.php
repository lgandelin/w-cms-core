<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;

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
