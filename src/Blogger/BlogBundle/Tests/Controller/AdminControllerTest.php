<?php

namespace Blogger\BlogBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;

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
    
    function xtestLogin()
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/admin/post/new');
        $this->assertTrue($client->getResponse()->isSuccessful());
        
        //Utils::log($crawler->text());
        
        //get the form and submit
        $form = $crawler->selectButton('Submit')->form();
        $crawler = $client->submit($form, $this->getOkData());
        
        Utils::log($crawler->text()); //while it does insert, the blog/show page has errors: "An exception has been thrown during the rendering of a template ("The security context contains no authentication token. One possible reason may be that there is no firewall configured for this URL.") in "BloggerBlogBundle:Blog:show.html.twig". (500 Internal Server Error)"
        
        //Utils::log(print_r($_SESSION, true));
        /*$crawler = $client->followRedirect();
        echo $crawler->text();
        $this->assertTrue($client->getResponse()->isSuccessful());*/
    }
    
    function testFail()
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/admin/post/new');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $data = $this->getOkData();
        //unset($data['form[file]']);
        $data['form[file]'] = new UploadedFile(__DIR__ . '/../Fixtures/foo.txt', 'foo.txt', 'text/plain', '4 ');
    
        //get the form and submit
        $form = $crawler->selectButton('Submit')->form();
        $crawler = $client->submit($form, $data);
    
        Utils::log($crawler->text());

    }
    
    
    function getOkData(){
        return array(
                  'form[title]' => 'Post Test'
                , 'form[blog]' => 'This is a monumental test for us.'
                , 'form[tags]' => 'lol ok'
                , 'form[file]' => new UploadedFile(__DIR__ . '/../Fixtures/foo.png', 'foo.png', 'image/png', '132674 ')
                );
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
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
        */

        return $client;
    }

}

