<?php


class WebsiteTest extends PHPUnit_Framework_TestCase {

    public function testConstruct()
    {
        $website = new \CMS\Entities\Website();

        $this->assertInstanceOf('\CMS\Entities\Website', $website);
    }

    public function testGetName()
    {
        $website = new \CMS\Entities\Website();
        $website->setName('My Website');

        $this->assertEquals('My Website', $website->getName());
    }

    public function testGetUrl()
    {
        $website = new \CMS\Entities\Website();
        $website->setUrl('http://my-website.fr');

        $this->assertEquals('http://my-website.fr', $website->getUrl());
    }

}