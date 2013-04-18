<?php

namespace Blogger\BlogBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog")
 */
class Blog {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $title;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $author;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $blog;
    
    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $image;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $tags;
    
    protected $comments;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;
}