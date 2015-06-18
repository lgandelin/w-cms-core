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
            $content->media = (new GetMediaInteractor())->getMediaByID($this->getMediaID(), true);
            $content->mediaLink = $this->getMediaLink();

            if ($this->getMediaFormatID()) {
                $mediaFormat = (new GetMediaFormatInteractor())->getMediaFormatByID($this->getMediaFormatID(), true);
                $content->media->fileName = $mediaFormat->width . '_' . $mediaFormat->height . '_' . $content->media->fileName;
            }

            return $content;
        }

        return null;
    }


}
