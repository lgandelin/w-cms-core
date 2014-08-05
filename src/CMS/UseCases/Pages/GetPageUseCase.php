<?php

namespace CMS\UseCases\Pages;

interface GetPageUseCase
{
    public function getByID($pageID);
}