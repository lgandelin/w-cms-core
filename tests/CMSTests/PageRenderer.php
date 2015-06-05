<?php

namespace CMSTests;

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
        $content = '<content>';
        switch ($block->getType()) {
            case 'html' :
                $content .= $block->getContentData()->html;
            break;

            case 'menu' :
                if ($block->getContentData()) {
                    foreach ($block->getContentData()->items as $item) {
                        $content .= '<item>' . $item->label . '</item>';
                    }
                }
            break;

            default:
            break;
        }
        $content .= '</content>';

        return $content;
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
