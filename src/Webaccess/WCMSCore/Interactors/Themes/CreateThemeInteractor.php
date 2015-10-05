<?php

namespace Webaccess\WCMSCore\Interactors\Themes;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\Theme;

class CreateThemeInteractor
{
    public function run(DataStructure $themeStructure)
    {
        $theme = (new Theme())->setInfos($themeStructure);
        $theme->valid();

        if ($this->anotherThemeExistsWithSameIdentifier($theme->getIdentifier())) {
            throw new \Exception('There is already a theme with the same identifier');
        }

        Context::get('theme_repository')->createTheme($theme);
    }

    private function anotherThemeExistsWithSameIdentifier($themeIdentifier)
    {
        return Context::get('theme_repository')->findByIdentifier($themeIdentifier);
    }
} 