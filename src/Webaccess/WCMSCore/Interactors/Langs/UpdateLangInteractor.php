<?php

namespace Webaccess\WCMSCore\Interactors\Langs;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;

class UpdateLangInteractor extends GetLangInteractor
{
    public function run($langID, DataStructure $langStructure)
    {
        if ($lang = $this->getLangByID($langID)) {
            $lang->setInfos($langStructure);
            $lang->valid();

            Context::get('lang_repository')->updateLang($lang);
        }
    }
}
