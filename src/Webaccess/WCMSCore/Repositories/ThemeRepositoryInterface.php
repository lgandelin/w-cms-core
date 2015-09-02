<?php
namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\Theme;

interface ThemeRepositoryInterface
{
    public function findSelectedThemeIdentifier();

    public function updateTheme(Theme $theme);

    public function createTheme(Theme $theme);

    public function findByID($themeID);

    public function findAll();
}