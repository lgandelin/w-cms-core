<?php

namespace Webaccess\WCMSCore\Entities\Blocks;

use Webaccess\WCMSCore\Entities\Block;

class MediaBlock extends Block
{
    private $mediaID;
    private $mediaLink;
    private $mediaFormatID;

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

    public function setMediaFormatID($mediaFormatID)
    {
        $this->mediaFormatID = $mediaFormatID;
    }

    public function getMediaFormatID()
    {
        return $this->mediaFormatID;
    }
}
