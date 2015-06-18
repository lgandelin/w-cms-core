<?php

namespace CMS\Structures\Blocks;

use CMS\Entities\Blocks\MediaBlock;
use CMS\Structures\DataStructure;

class MediaBlockStructure extends DataStructure
{
    public $media_id;
    public $media_link;
    public $media_format_id;

    public function getBlock()
    {
        return new MediaBlock();
    }
}
