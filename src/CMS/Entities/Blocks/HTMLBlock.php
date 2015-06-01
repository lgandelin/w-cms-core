<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\BlockStructure;

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

    public function getContent()
    {
        return $this->html;
    }

    public function updateContent(BlockStructure $blockStructure)
    {
        if (
            isset($blockStructure->html) &&
            $blockStructure->html !== null &&
            $blockStructure->html != $this->getHTML()
        ) {
            $this->setHTML($blockStructure->html);
        }
    }
}
