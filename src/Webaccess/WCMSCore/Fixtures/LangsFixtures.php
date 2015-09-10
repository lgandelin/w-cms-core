<?php

namespace Webaccess\WCMSCore\Fixtures;

use Webaccess\WCMSCore\Entities\Lang;
use Webaccess\WCMSCore\Context;

class LangsFixtures {

    public static function run()
    {
        $langs = [
            ['code' => 'en', 'name' => 'English', 'prefix' => '', 'is_default' => true],
            ['code' => 'fr', 'name' => 'Français', 'prefix' => '/fr', 'is_default' => false],
        ];

        foreach ($langs as $l) {
            $lang = new Lang();
            $lang->setCode($l['code']);
            $lang->setName($l['name']);
            $lang->setPrefix($l['prefix']);
            $lang->setIsDefault($l['is_default']);

            Context::get('lang_repository')->createLang($lang);
        }
    }
}