<?php

namespace Blogger\BlogBundle\Tests\Controller;

use Blogger\BlogBundle\Helpers\Utils;

use Symfony\Component\BrowserKit\Cookie;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{

    function testRestricted()
    {
        $client = static::createClient();
        $client->request('GET', '/admin');
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('h1:contains("Login")')->count());
        
        $form = $crawler->selectButton('Login')->form();
        $client->submit($form);
        $crawler = $client->followRedirect();
        //echo $crawler->text(); //contains "Bad credentials"
        
        /*
        //login
        $form = $crawler->selectButton('Login')->form();
        $client->submit($form, array('_username' => 'admin', '_password' => '123456'));
        $crawler = $client->followRedirect();
        $crawler = $client->followRedirect();
        echo $crawler->text(); //apparently it is impossible to test*/
    }
    
    function testLogin()
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/admin/post/new');
        $this->assertTrue($client->getResponse()->isSuccessful());
        
        //Utils::log($crawler->text());
        
        //get the form and submit
        $form = $crawler->selectButton('Submit')->form();
        $crawler = $client->submit($form);
        //$crawler = $client->followRedirect();
        
        Utils::log($crawler->text());
        
        //Utils::log(print_r($_SESSION, true));
        /*$crawler = $client->followRedirect();
        echo $crawler->text();
        $this->assertTrue($client->getResponse()->isSuccessful());*/
    }
    
    function login()
    {
        /*$client = static::createClient();
        
        $session = $client->getContainer()->get('session');
        $firewall = 'secured_area';
        $token = new UsernamePasswordToken('admin', null, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();
        
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);*/
        
        $client = static::createClient(array(), array(
                'PHP_AUTH_USER' => 'admin',
                'PHP_AUTH_PW'   => '123456',
        ));
        $client->followRedirects();
        
        $firewall = 'secured_area';
        $token = new UsernamePasswordToken('admin', null, $firewall, array('ROLE_USER'));
        self::$kernel->getContainer()->get('security.context')->setToken($token);
        
        /*
        $session = $client->getContainer()->get('session');
        $firewall = 'secured_area';
        $token = new UsernamePasswordToken('admin', null, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();
        
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);*/
        
        
        return $client;
    }

}

