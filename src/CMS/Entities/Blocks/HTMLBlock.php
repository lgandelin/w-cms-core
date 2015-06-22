<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;

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

    public function getContentData()
    {
        $content = new \StdClass();
        $content->html = $this->html;

        return $content;
    }
}
