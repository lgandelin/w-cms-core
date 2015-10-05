<?php

namespace Webaccess\WCMSCore\Interactors\Themes;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;

class UpdateThemeInteractor
{
    public function run($themeID, DataStructure $themeStructure)
    {
        $theme = Context::get('theme_repository')->findByID($themeID);
        $theme->setInfos($themeStructure);

        Context::get('theme_repository')->updateTheme($theme);
    }
} 