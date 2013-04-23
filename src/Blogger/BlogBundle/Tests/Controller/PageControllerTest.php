<?php

namespace Blogger\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase {
	
	public function testAbout()
	{
		$client = static::createClient();

		$crawler = $client->request('GET', '/about');
		
		$this->assertEquals(1, $crawler->filter('h1:contains("About sfblog")')->count());
	}
	
	function testIndex()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/');
		$this->assertTrue($crawler->filter('article.blog')->count()>0);
		
		//find first link
		$blogLink = $crawler->filter('article.blog h2 a')->first();
		$blogTitle = $blogLink->text();
		$crawler = $client->click($blogLink->link());
        $this->assertEquals(1, $crawler->filter('h2:contains("' . $blogTitle . '")' )->count());
		
	}
	
	function testContact()
	{
	   $client = static::createClient();
	   $crawler = $client->request('GET', '/contact');

	   $this->assertEquals(1, $crawler->filter('h1:contains("Contact sfblog")')->count() );
	   
	   $form = $crawler->selectButton('Submit')->form();
	   $form['contact[name]'] = 'name';
	   $form['contact[email]'] = 'email@email.com';
	   $form['contact[subject]'] = 'Subject';
	   $form['contact[body]'] = 'The comment body must be at least 50 characters long as there is a validation constrain on the Enquiry entity';
	   
	   $crawler = $client->submit($form);
	   $crawler = $client->followRedirect();
	   
	   $this->assertEquals(1, $crawler->filter('.blogger-notice:contains("Your contact enquiry was successfully sent. Thank you!")')->count());
	   
	   
	}
	
}

