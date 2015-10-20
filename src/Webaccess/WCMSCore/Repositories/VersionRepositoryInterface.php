<?php

namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\Version;

interface VersionRepositoryInterface
{
    public function findByID($versionID);

    public function findByPageID($pageID);

    public function findAll();

    public function createVersion(Version $version);

    public function updateVersion(Version $version);

    public function deleteVersion($versionID);
}
