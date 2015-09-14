<?php

namespace Webaccess\WCMSCore\Interactors\Langs;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Lang;
use Webaccess\WCMSCore\DataStructure;

class CreateLangInteractor
{
    public function run(DataStructure $langStructure)
    {
        $lang = new Lang();
        $lang->setInfos($langStructure);
        $lang->valid();

        return Context::get('lang_repository')->createLang($lang);
    }
}
