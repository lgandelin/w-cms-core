<?php

namespace CMS\UseCases\Pages;

use CMS\Structures\PageStructure;

interface CreatePageUseCase
{
    public function run(PageStructure $pageStructure);
    public function anotherExistingPageWithSameIdentifier($identifier);
    public function anotherExistingPageWithSameUri($uri);
}