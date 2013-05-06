<?php

namespace Blogger\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{

    function testRestricted()
    {
        $client = static::createClient();
        $client->request('GET', '/admin');
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('h1:contains("Login")')->count());
        

    }

}

