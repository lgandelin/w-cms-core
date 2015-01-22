<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;

class MediaBlock extends Block
{
    private $mediaID;

    public function setMediaID($mediaID)
    {
        $this->mediaID = $mediaID;
    }

    public function getMediaID()
    {
        return $this->mediaID;
    }
}
