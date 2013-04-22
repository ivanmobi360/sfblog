<?php
namespace Blogger\BlogBundle\Tests\Entity;


use Blogger\BlogBundle\Entity\Blog;

class BlogTest extends \PHPUnit_Framework_TestCase
{
    
    public function testSlugify()
    {
        $blog = new Blog();
        $this->assertEquals('hello-world', $blog->slugify('Hello World'));
    }
}
