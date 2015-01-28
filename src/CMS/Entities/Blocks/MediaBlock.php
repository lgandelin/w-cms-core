<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;

class MediaBlock extends Block
{
    private $mediaID;
    private $mediaLink;

    public function setMediaID($mediaID)
    {
        $this->mediaID = $mediaID;
    }

    public function getMediaID()
    {
        return $this->mediaID;
    }

    public function setMediaLink($mediaLink)
    {
        $this->mediaLink = $mediaLink;
    }

    public function getMediaLink()
    {
        return $this->mediaLink;
    }

}
