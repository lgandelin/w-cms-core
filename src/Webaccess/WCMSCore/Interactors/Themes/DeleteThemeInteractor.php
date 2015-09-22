<?php

namespace Webaccess\WCMSCore\Interactors\Themes;

use Webaccess\WCMSCore\Context;

class DeleteThemeInteractor extends GetThemeInteractor
{
    public function run($themeIdentifier)
    {
        if ($theme = $this->getThemeByIdentifier($themeIdentifier)) {
            Context::get('theme_repository')->deleteTheme($theme->getID());
        }
    }
} 