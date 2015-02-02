<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Structures\Blocks\HTMLBlockStructure;

class HTMLBlock extends Block
{
    private $html;

    public function setHTML($html)
    {
        $this->html = $html;
    }

    public function getHTML()
    {
        return $this->html;
    }

    public function getStructure()
    {
        $blockStructure = new HTMLBlockStructure();
        $blockStructure->html = $this->getHTML();

        return $blockStructure;
    }
}
