<?php

namespace Blogger\BlogBundle\Tests\Entity\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogRepositoryTest extends WebTestCase
{

    /**
     * @var BlogRepository
     */
    private $blogRepository;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        
        $this->blogRepository = $kernel->getContainer()->get('doctrine.orm.entity_manager')
        ->getRepository('BloggerBlogBundle:Blog');

    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->blogRepository = null;

        parent::tearDown();
    }



    public function testGetTags()
    {
        $tags = $this->blogRepository->getTags();
    
    	$this->assertTrue(count($tags)>1);
    	
    	$this->assertContains('symblog', $tags);

    }


    public function testGetTagWeights()
    {
        $tagsWeight = $this->blogRepository->getTagWeights(
            array('php', 'code', 'code', 'symblog', 'blog')
        );

        $this->assertTrue(count($tagsWeight) > 1);

        // Test case where count is over max weight of 5
        $tagsWeight = $this->blogRepository->getTagWeights(
            array_fill(0, 10, 'php')
        );

        $this->assertTrue(count($tagsWeight) >= 1);

        // Test case with multiple counts over max weight of 5
        $tagsWeight = $this->blogRepository->getTagWeights(
            array_merge(array_fill(0, 10, 'php'), array_fill(0, 2, 'html'), array_fill(0, 6, 'js'))
        );

        $this->assertEquals(5, $tagsWeight['php']);
        $this->assertEquals(3, $tagsWeight['js']);
        $this->assertEquals(1, $tagsWeight['html']);

        // Test empty case
        $tagsWeight = $this->blogRepository->getTagWeights(array());

        $this->assertEmpty($tagsWeight);
    }

}

