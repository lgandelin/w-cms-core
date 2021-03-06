<?php

namespace Webaccess\WCMSCore\Interactors\Themes;

use Webaccess\WCMSCore\Context;

class GetThemeInteractor
{
    public function getThemeSelected($structure = false)
    {
        if (!$theme = Context::get('theme_repository')->findSelectedTheme()) {
            return false;
        }

        return  ($structure) ? $theme->toStructure() : $theme;
    }

    public function getThemeByIdentifier($themeIdentifier, $structure = false)
    {
        if (!$theme = Context::get('theme_repository')->findByIdentifier($themeIdentifier)) {
            throw new \Exception('The theme was not found : ' . $themeIdentifier);
        }

        return  ($structure) ? $theme->toStructure() : $theme;
    }
} 