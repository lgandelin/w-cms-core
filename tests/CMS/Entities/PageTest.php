<?php

use CMS\Entities\Page;
use CMS\Entities\Website;
    
class PageTest extends PHPUnit_Framework_TestCase {

    public function testConstruct()
    {
        $page = new Page();

        $this->assertInstanceOf('CMS\Entities\Page', $page);
    }

    public function testGetName()
    {
        $page = new Page();
        $page->setName('My Page');

        $this->assertEquals('My Page', $page->getName());
    }

    public function testGetUri()
    {
        $page = new Page();
        $page->setUri('/home');

        $this->assertEquals('/home', $page->getUri());
    }

    public function testGetIdentifier()
    {
        $page = new Page();
        $page->setIdentifier('home');

        $this->assertEquals('home', $page->getIdentifier());
    }

    public function testGetText()
    {
        $page = new Page();
        $page->setText('<p>Quisque id tellus ac velit tincidunt varius ut sit amet metus. Curabitur tempor condimentum ante ut interdum. Integer vel diam ultrices erat rhoncus faucibus in venenatis lectus. Nam id erat nulla. Duis sit amet magna id odio dignissim rutrum a sit amet nibh. Ut vulputate mauris malesuada enim eleifend ullamcorper. Nam placerat tempor cursus. Nullam eget porttitor felis, ac dictum leo. Donec euismod odio ac ante facilisis, et tristique risus viverra.</p>');

        $this->assertEquals('<p>Quisque id tellus ac velit tincidunt varius ut sit amet metus. Curabitur tempor condimentum ante ut interdum. Integer vel diam ultrices erat rhoncus faucibus in venenatis lectus. Nam id erat nulla. Duis sit amet magna id odio dignissim rutrum a sit amet nibh. Ut vulputate mauris malesuada enim eleifend ullamcorper. Nam placerat tempor cursus. Nullam eget porttitor felis, ac dictum leo. Donec euismod odio ac ante facilisis, et tristique risus viverra.</p>', $page->getText());
    }

    public function testGetWebsite()
    {
        $page = new Page();
        $website = new Website();
        $page->setWebsite($website);

        $this->assertInstanceOf('CMS\Entities\Website', $page->getWebsite());
        $this->assertEquals($website, $page->getWebsite());
    }

    public function testGetMetaTitle()
    {
        $page = new Page();
        $page->setMetaTitle('Home | Webaccess');

        $this->assertEquals('Home | Webaccess', $page->getMetaTitle());
    }

    public function testGetMetaDescription()
    {
        $page = new Page();
        $page->setMetaDescription('<p>Quisque id tellus ac velit tincidunt varius ut sit amet metus. Curabitur tempor condimentum ante ut interdum. Integer vel diam ultrices erat rhoncus faucibus in venenatis lectus. Nam id erat nulla. Duis sit amet magna id odio dignissim rutrum a sit amet nibh. Ut vulputate mauris malesuada enim eleifend ullamcorper.</p>');

        $this->assertEquals('<p>Quisque id tellus ac velit tincidunt varius ut sit amet metus. Curabitur tempor condimentum ante ut interdum. Integer vel diam ultrices erat rhoncus faucibus in venenatis lectus. Nam id erat nulla. Duis sit amet magna id odio dignissim rutrum a sit amet nibh. Ut vulputate mauris malesuada enim eleifend ullamcorper.</p>', $page->getMetaDescription());
    }

    public function testGetMetaKeywords()
    {
        $page = new Page();
        $page->setMetaKeywords('Quisque id tellus ac velit');

        $this->assertEquals('Quisque id tellus ac velit', $page->getMetaKeywords());
    }
}