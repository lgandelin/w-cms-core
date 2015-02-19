<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Structures\Blocks\MediaBlockStructure;
use CMS\Structures\BlockStructure;

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

    public function getStructure()
    {
        $blockStructure = new MediaBlockStructure();
        $blockStructure->media_id = $this->getMediaID();
        $blockStructure->media_link = $this->getMediaLink();
        $blockStructure->media_format_id = $this->getMediaFormatID();

        return $blockStructure;
    }

    public function updateContent(BlockStructure $blockStructure)
    {
        if ($blockStructure->media_id !== null && $blockStructure->media_id != $this->getMediaID()) {
            $this->setMediaID($blockStructure->media_id);
        }

        if ($blockStructure->media_link !== null && $blockStructure->media_link != $this->getMediaLink()) {
            $this->setMediaLink($blockStructure->media_link);
        }

        if (
            $blockStructure->media_format_id !== null &&
            $blockStructure->media_format_id != $this->getMediaFormatID()
        ) {
            $this->setMediaFormatID($blockStructure->media_format_id);
        }
    }
}
