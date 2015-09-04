<?php

namespace Webaccess\WCMSCore\Interactors\Themes;

use Webaccess\WCMSCore\Context;

class SelectThemeInteractor
{
    public function run($themeIdentifier)
    {
        $themes = Context::get('theme')->findAll();

        foreach ($themes as $theme) {
            if ($theme->getIdentifier() == $themeIdentifier) {
                $theme->setIsSelected(true);
            } else {
                $theme->setIsSelected(false);
            }
            (new UpdateThemeInteractor())->updateTheme($theme->getID(), $theme->toStructure());
        }
    }
} 