<?php

namespace CMS\UseCases\Pages;

interface DeletePageUseCase extends GetPageUseCase
{
    public function run($pageID);
}