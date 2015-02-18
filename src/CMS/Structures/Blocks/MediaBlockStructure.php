<?php

namespace CMS\Structures\Blocks;

use CMS\Entities\Blocks\MediaBlock;
use CMS\Structures\BlockStructure;

class MediaBlockStructure extends BlockStructure
{
    public $media_id;
    public $media_link;
    public $media_format_id;

    public function getBlock()
    {
        return new MediaBlock();
    }
}
