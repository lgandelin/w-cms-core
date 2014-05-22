<?php

class PageTest extends PHPUnit_Framework_TestCase {

    public function testConstruct()
    {
        $page = new \CMS\Entities\Page();

        $this->assertInstanceOf('\CMS\Entities\Page', $page);
    }

    public function testGetName()
    {
        $page = new \CMS\Entities\Page();
        $page->setName('My Page');

        $this->assertEquals('My Page', $page->getName());
    }

    public function testGetUri()
    {
        $page = new \CMS\Entities\Page();
        $page->setUri('/home');

        $this->assertEquals('/home', $page->getUri());
    }

    public function testGetIdentifier()
    {
        $page = new \CMS\Entities\Page();
        $page->setIdentifier('home');

        $this->assertEquals('home', $page->getIdentifier());
    }

    public function testGetText()
    {
        $page = new \CMS\Entities\Page();
        $page->setText('<p>Quisque id tellus ac velit tincidunt varius ut sit amet metus. Curabitur tempor condimentum ante ut interdum. Integer vel diam ultrices erat rhoncus faucibus in venenatis lectus. Nam id erat nulla. Duis sit amet magna id odio dignissim rutrum a sit amet nibh. Ut vulputate mauris malesuada enim eleifend ullamcorper. Nam placerat tempor cursus. Nullam eget porttitor felis, ac dictum leo. Donec euismod odio ac ante facilisis, et tristique risus viverra.</p>');

        $this->assertEquals('<p>Quisque id tellus ac velit tincidunt varius ut sit amet metus. Curabitur tempor condimentum ante ut interdum. Integer vel diam ultrices erat rhoncus faucibus in venenatis lectus. Nam id erat nulla. Duis sit amet magna id odio dignissim rutrum a sit amet nibh. Ut vulputate mauris malesuada enim eleifend ullamcorper. Nam placerat tempor cursus. Nullam eget porttitor felis, ac dictum leo. Donec euismod odio ac ante facilisis, et tristique risus viverra.</p>', $page->getText());
    }

    public function testGetWebsite()
    {
        $page = new \CMS\Entities\Page();
        $website = new \CMS\Entities\Website();
        $page->setWebsite($website);

        $this->assertInstanceOf('\CMS\Entities\Website', $page->getWebsite());
        $this->assertEquals($website, $page->getWebsite());
    }

}