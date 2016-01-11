<?php

namespace Webaccess\WCMSCoreTests\Repositories;

use Webaccess\WCMSCore\Entities\Version;
use Webaccess\WCMSCore\Repositories\VersionRepositoryInterface;

class InMemoryVersionRepository implements VersionRepositoryInterface
{
    private $versions;

    public function __construct()
    {
        $this->versions = [];
    }

    public function findByID($versionID)
    {
        foreach ($this->versions as $version) {
            if ($version->getID() == $versionID) {
                return $version;
            }
        }

        return false;
    }

    public function findByPageID($pageID)
    {
        $versions = [];
        foreach ($this->versions as $version) {
            if ($version->getPageID() == $pageID) {
                $versions[]= $version;
            }
        }

        return $versions;
    }

    public function findAll()
    {
        return $this->versions;
    }

    public function createVersion(Version $version)
    {
        $versionID = sizeof($this->versions) + 1;
        $version->setID($versionID);
        $this->versions[]= $version;

        return $versionID;
    }

    public function updateVersion(Version $version)
    {
        foreach ($this->versions as $versionModel) {
            if ($versionModel->getID() == $version->getID()) {
                $versionModel->setPageID($version->getPageID());
                $versionModel->setNumber($version->getNumber());
                $versionModel->setUpdatedDate($version->getUpdatedDate());
            }
        }
    }

    public function deleteVersion($versionID)
    {
        foreach ($this->versions as $i => $version) {
            if ($version->getID() == $versionID) {
                unset($this->versions[$i]);
            }
        }
    }
} 