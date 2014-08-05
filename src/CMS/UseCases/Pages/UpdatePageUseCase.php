<?php
namespace CMS\UseCases\Pages;

interface UpdatePageUseCase extends GetPageUseCase
{
    public function run($pageID, $pageStructure);
    public function getPageUpdated($originalPageStructure, $pageStructure);
    public function anotherPageExistsWithSameURI($pageID, $pageURI);
    public function anotherPageExistsWithSameIdentifier($pageID, $pageIdentifier);
}