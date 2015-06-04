<?php

namespace CMSTests\Repositories;

use CMS\Entities\Lang;
use CMS\Repositories\LangRepositoryInterface;

class InMemoryLangRepository implements LangRepositoryInterface
{
    private $langs;

    public function __construct()
    {
        $this->langs = [];
    }

    public function findByID($langID)
    {
        foreach ($this->langs as $lang) {
            if ($lang->getID() == $langID) {
                return $lang;
            }
        }

        return false;
    }

    public function findAll()
    {
        return $this->langs;
    }

    public function createLang(Lang $lang)
    {
        $langID = sizeof($this->langs) + 1;
        $lang->setID($langID);
        $this->langs[]= $lang;

        return $langID;
    }

    public function updateLang(lang $lang)
    {
        foreach ($this->langs as $langModel) {
            if ($langModel->getID() == $lang->getID()) {
                if ($lang->getName()) {
                    $langModel->setName($lang->getName());
                }
                if ($lang->getPrefix()) {
                    $langModel->setPrefix($lang->getPrefix());
                }
                $langModel->setIsDefault($lang->getIsDefault());
            }
        }
    }

    public function deleteLang($langID)
    {
        foreach ($this->langs as $i => $lang) {
            if ($lang->getID() == $langID) {
                unset($this->langs[$i]);
            }
        }
    }

    public function findDefautLangID()
    {
        foreach ($this->langs as $lang) {
            if ($lang->getIsDefault()) {
                return true;
            }
        }

        return false;
    }
}
