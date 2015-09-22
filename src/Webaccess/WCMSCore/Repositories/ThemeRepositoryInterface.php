<?php
namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\Theme;

interface ThemeRepositoryInterface
{
    public function findByID($themeID);

    public function findByIdentifier($themeIdentifier);

    public function findSelectedTheme();

    public function findAll();

    public function createTheme(Theme $theme);

    public function updateTheme(Theme $theme);
}