<?php

namespace Webaccess\WCMSCore\Entities\Blocks;

use Webaccess\WCMSCore\Entities\Block;

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
