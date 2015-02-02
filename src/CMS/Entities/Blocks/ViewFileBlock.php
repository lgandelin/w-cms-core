<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Structures\Blocks\ViewFileBlockStructure;

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

    public function getStructure()
    {
        $blockStructure = new ViewFileBlockStructure();
        $blockStructure->view_file = $this->getViewFile();

        return $blockStructure;
    }

    public function updateContent(ViewFileBlockStructure $blockStructure)
    {
        if ($blockStructure->view_file !== null && $blockStructure->view_file != $this->getViewFile()) {
            $this->setViewFile($blockStructure->view_file);
        }
    }
}
