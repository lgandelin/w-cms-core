<?php

use CMS\Entities\Website;

class WebsiteTest extends PHPUnit_Framework_TestCase {

    public function testConstruct()
    {
        $website = new Website();

        $this->assertInstanceOf('CMS\Entities\Website', $website);
    }

    public function testGetName()
    {
        $website = new Website();
        $website->setName('My Website');

        $this->assertEquals('My Website', $website->getName());
    }

    public function testGetUrl()
    {
        $website = new Website();
        $website->setUrl('http://my-website.fr');

        $this->assertEquals('http://my-website.fr', $website->getUrl());
    }

}