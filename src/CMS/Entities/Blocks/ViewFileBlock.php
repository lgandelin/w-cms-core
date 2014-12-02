<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;

class ViewFileBlock extends Block
{
    private $viewFile;

    public function setViewFile($viewFile)
    {
        $this->viewFile = $viewFile;
    }

    public function getViewFile()
    {
        return $this->viewFile;
    }
}
