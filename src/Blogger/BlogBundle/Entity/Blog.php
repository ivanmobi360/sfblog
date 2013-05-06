<?php

namespace Blogger\BlogBundle\Entity;


use Symfony\Component\HttpFoundation\File\UploadedFile;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Entity\Repository\BlogRepository")
 * @ORM\Table(name="blog")
 * @ORM\HasLifecycleCallbacks
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
    protected $slug;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $title;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="blogs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $blog;
    
    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $image;
    
    /**
     * @Assert\File(
     *     maxSize="1024k",
     *     mimeTypes =  {"image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Please upload a valid image"
     *     )
     */
    protected $file; //private element to hold uploaded file data
    
    /**
     * @ORM\Column(type="text")
     */
    protected $tags;
    
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="blog")
     */
    protected $comments;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;
    
    public function __construct() {
        
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }
    
    public function setUpdatedValue()
    {
        $this->setUpdated(new \DateTime());
    }

    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Blog
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        $this->setSlug($title);
        
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Set blog
     *
     * @param string $blog
     * @return Blog
     */
    public function setBlog($blog)
    {
        $this->blog = $blog;
    
        return $this;
    }

    /**
     * Get blog
     *
     * @return string 
     */
    public function getBlog($length = null)
    {
        if (false === is_null($length) && $length >0 )
            return substr ($this->blog, 0, $length);
        else
            return $this->blog;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Blog
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return Blog
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set created
     *
     * @param DateTime $created
     * @return Blog
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param DateTime $updated
     * @return Blog
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add comments
     *
     * @param \Blogger\BlogBundle\Entity\Comment $comments
     * @return Blog
     */
    public function addComment(\Blogger\BlogBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Blogger\BlogBundle\Entity\Comment $comments
     */
    public function removeComment(\Blogger\BlogBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
    
    public function __toString(){
    	return $this->getTitle();
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Blog
     */
    public function setSlug($slug)
    {
        $this->slug = $this->slugify($slug);
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    public function slugify($text)
    {
    	// replace non letter or digits by -
    	$text = preg_replace('#[^\\pL\d]+#u', '-', $text);
    
    	// trim
    	$text = trim($text, '-');
    
    	// transliterate
    	if (function_exists('iconv'))
    	{
    		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    	}
    
    	// lowercase
    	$text = strtolower($text);
    
    	// remove unwanted characters
    	$text = preg_replace('#[^-\w]+#', '', $text);
    
    	if (empty($text))
    	{
    		return 'n-a';
    	}
    
    	return $text;
    }
    
    // ******************** uploaded file stuff ************************
    private $temp;
    
    /**
     * @return UploadedFile
     */
    public function getFile(){
        return $this->file;
    }
    
    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file=null){
        $this->file = $file;
        //check if we have an old image path
        if(isset($this->image)){
            //store the old name to delete after the update
            $this->temp = $this->image;
            $this->image = null;
        }else{
            $this->image = 'initial';
        }        
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile() ){
            //generate some unique filename
            $filename = sha1(uniqid(mt_rand(), true));
            $this->image = $filename . '.' . $this->getFile()->guessExtension();
        }
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if(null == $this->getFile()){
            return;
        }
        
        $this->getFile()->move($this->getImagesFileSystemDir(), $this->image);
        
        //check if we have an old image
        if(isset($this->temp)){
            //delete old image
            unlink($this->getImagesFileSystemDir() . '/'  .$this->temp);
            $this->temp = null;
        }
        
        $this->file = null;
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload(){
        if($file = $this->getImageAbsolutePath()){
            unlink($file);
        }
    }
    
    
    protected function getImagesFileSystemDir()
    {
        return __DIR__.'/../../../../web/'.$this->getImagesWebDir();
    }
    
    protected function getImagesWebDir(){
        return 'images';
    }
    
    function getImageUrl(){
        return null == $this->image ? null : $this->getImagesWebDir() .$this->image;
    }
    
    function getImageAbsolutePath(){
        return null == $this->image ? null : $this->getImagesFileSystemDir() . $this->image;
    }
    
    
    
    
    

    /**
     * Set user
     *
     * @param \Blogger\BlogBundle\Entity\User $user
     * @return Blog
     */
    public function setUser(\Blogger\BlogBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Blogger\BlogBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    
    
    
    
}