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
		$blogLink = $crawler->filter('article.blog h2 a')->eq(1);//first();
		$blogTitle = $blogLink->text();
		//echo $blogLink->link()->getUri();
		$crawler = $client->click($blogLink->link());
		//$crawler = $client->request( 'GET', $blogLink->link()->getUri());
		
		//$this->assertEquals(1, $crawler->filter('h2:contains("' . $blogTitle . '")' )->count());
		
	}
	
}

