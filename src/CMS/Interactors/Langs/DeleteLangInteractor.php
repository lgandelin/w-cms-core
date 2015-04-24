<?php

namespace CMS\Interactors\Langs;

class DeleteLangInteractor extends GetLangInteractor
{
    public function run($langID)
    {
        if ($this->getLangByID($langID)) {
            $this->repository->deleteLang($langID);
        }
    }
}
