<?php

namespace Webaccess\WCMSCore\Interactors\Langs;

use Webaccess\WCMSCore\Context;

class DeleteLangInteractor extends GetLangInteractor
{
    public function run($langID)
    {
        if ($this->getLangByID($langID)) {
            Context::get('lang')->deleteLang($langID);
        }
    }
}
