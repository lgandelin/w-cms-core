<?php

namespace CMSTests;

use CMS\Entities\Blocks\HTMLBlock;
use CMS\Entities\Page;

class PageRenderer
{
    public static function render(Page $page) {
        $pageContent = '<page><title>' . $page->getName() . '</title>';
        foreach ($page->areas as $area) {
            $pageContent .= ($area->getDisplay()) ? self::renderArea($area) : '';
        }
        $pageContent .= '</page>';

        return $pageContent;
    }

    private static function renderBlockContent($block)
    {
        if ($block instanceof HTMLBlock)
            return '<content>' . $block->getHTML() . '</content>';
    }

    private static function renderBlock($block)
    {
        return '<block>' . self::renderEntityHeader($block) . self::renderBlockContent($block) . '</block>';
    }

    private static function renderArea($area)
    {
        $pageContent = '<area>' . self::renderEntityHeader($area);
        foreach ($area->blocks as $block) {
            $pageContent .= ($block->getDisplay()) ? self::renderBlock($block) : '';
        }
        $pageContent .= '</area>';

        return $pageContent;
    }

    private static function renderEntityHeader($entity)
    {
        return '<title>' . $entity->getName() . ' (' . $entity->getWidth() . ')</title>';
    }
}
