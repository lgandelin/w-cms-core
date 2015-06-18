<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Structures\DataStructure;

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

    public function getStructure()
    {
        $blockStructure = new DataStructure();
        $blockStructure->view_path = $this->getViewPath();

        return $blockStructure;
    }

    public function updateContent(DataStructure $blockStructure)
    {
        if ($blockStructure->view_path !== null && $blockStructure->view_path != $this->getViewPath()) {
            $this->setViewPath($blockStructure->view_path);
        }
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
