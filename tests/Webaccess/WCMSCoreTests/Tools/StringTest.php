<?php

use Webaccess\WCMSCore\Tools\String;

class StringTest extends PHPUnit_Framework_TestCase
{
    public function testGetSlug()
    {
        $this->assertEquals('', String::getSlug(''));
        $this->assertEquals('test', String::getSlug('Test'));
        $this->assertEquals('another-test', String::getSlug('Another test'));
        $this->assertEquals('another-test-with-several-spaces', String::getSlug('Another test with several spaces'));
        $this->assertEquals('test-with-special-characters-end-of-test', String::getSlug('Test with special charàctèrs€$£¨/!\"%§ end of test'));
    }
} 