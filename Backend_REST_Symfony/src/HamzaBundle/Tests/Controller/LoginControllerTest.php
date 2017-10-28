<?php

namespace HamzaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testAuthenticate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/authenticate');
    }

}
