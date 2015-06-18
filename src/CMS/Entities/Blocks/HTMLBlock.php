<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Structures\DataStructure;

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
        $blockStructure = new DataStructure();
        $blockStructure->html = $this->getHTML();

        return $blockStructure;
    }

    public function getContentData()
    {
        $content = new \StdClass();
        $content->html = $this->html;

        return $content;
    }

    public function updateContent(DataStructure $blockStructure)
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
