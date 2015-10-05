<?php

namespace Webaccess\WCMSCore\Interactors\Themes;

class SelectThemeInteractor extends GetThemeInteractor
{
    public function run($themeIdentifier)
    {
        if ($theme = $this->getThemeByIdentifier($themeIdentifier)) {
            $theme->setIsSelected(true);
            (new UpdateThemeInteractor())->run($theme->getID(), $theme->toStructure());
        } else {
            throw new \Exception('Theme not found : ' . $themeIdentifier);
        }
    }
} 