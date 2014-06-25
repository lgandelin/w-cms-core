<?php

use CMS\Entities\User;

class UserTest extends PHPUnit_Framework_TestCase {

    public function testConstruct()
    {
        $user = new User();

        $this->assertInstanceOf('CMS\Entities\User', $user);
    }

    public function testGetLastName()
    {
        $user = new User();
        $user->setLastName('Doe');

        $this->assertEquals('Doe', $user->getLastName());
    }

    public function testGetFirstName()
    {
        $user = new User();
        $user->setFirstName('John');

        $this->assertEquals('John', $user->getFirstName());
    }

    public function testGetLogin()
    {
        $user = new User();
        $user->setLogin('jdoe');

        $this->assertEquals('jdoe', $user->getLogin());
    }

    public function testGetPassword()
    {
        $user = new User();
        $user->setPassword('ec4a5c1b5ed92af9cedce042c7a10c57cea7fb45');

        $this->assertEquals('ec4a5c1b5ed92af9cedce042c7a10c57cea7fb45', $user->getPassword());
    }

    public function testGetEmail()
    {
        $user = new User();
        $user->setEmail('jdoe@gmail.com');

        $this->assertEquals('jdoe@gmail.com', $user->getEmail());
    }

}
 