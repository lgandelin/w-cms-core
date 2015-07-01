<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Interactors\MediaFormats\GetMediaFormatInteractor;
use CMS\Interactors\Medias\GetMediaInteractor;

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

    public function getContentData()
    {
        if ($this->getMediaID()) {
            $content = new \StdClass();
            $content->media = (new GetMediaInteractor())->getMediaByID($this->getMediaID(), $this->getMediaFormatID(), true);
            $content->mediaLink = $this->getMediaLink();

            return $content;
        }

        return null;
    }


}
