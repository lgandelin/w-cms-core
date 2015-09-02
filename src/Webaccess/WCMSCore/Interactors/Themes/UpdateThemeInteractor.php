<?php

namespace Webaccess\WCMSCore\Interactors\Themes;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;

class UpdateThemeInteractor
{
    public function updateTheme($themeID, DataStructure $themeStructure)
    {
        $theme = Context::get('theme')->findByID($themeID);
        $theme->setInfos($themeStructure);

        Context::get('theme')->updateTheme($theme);
    }
} 