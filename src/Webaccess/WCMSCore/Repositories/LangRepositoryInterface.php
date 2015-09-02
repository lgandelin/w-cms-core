<?php

namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\Lang;

interface LangRepositoryInterface
{
    public function findByID($langID);

    public function findAll();

    public function createLang(Lang $lang);

    public function updateLang(Lang $lang);

    public function deleteLang($langID);
}
