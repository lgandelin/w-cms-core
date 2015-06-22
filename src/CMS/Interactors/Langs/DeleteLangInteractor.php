<?php

namespace CMS\Interactors\Langs;

use CMS\Context;

class DeleteLangInteractor extends GetLangInteractor
{
    public function run($langID)
    {
        if ($this->getLangByID($langID)) {
            Context::getRepository('lang')->deleteLang($langID);
        }
    }
}
