<?php
namespace Blogger\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="users")
 * @ORM\Entity
 *
 */
class User implements AdvancedUserInterface, \Serializable
{
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    protected $username;
    
    /**
     * @ORM\Column(type="string", length=32)
     */
    protected $salt;
    
    /**
     * @ORM\Column(type="string", length=40)
     */
    protected $password;
    
    
    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    protected $email;
    
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;
    
    /**
     * @ORM\OneToMany(targetEntity="Blog", mappedBy="user")
     */
    protected $blogs;
    
    function __construct(){
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
        $this->blogs = new ArrayCollection();
    }
    
    // ************************* Interfaces *******************************************
    public function serialize ()
    {
        return serialize(array($this->id));
    }

    public function unserialize ($serialized)
    {
        list($this->id) = unserialize($serialized);
    }

	
    
    /*
     * @see \Symfony\Component\Security\Core\User\UserInterface::getUsername()
    */
    public function getUsername ()
    {
        return $this->username;
    }
    
    /*
     * @see \Symfony\Component\Security\Core\User\UserInterface::getSalt()
    */
    public function getSalt ()
    {
        return $this->salt;
    }

	/* 
     * @see \Symfony\Component\Security\Core\User\UserInterface::getPassword()
     */
    public function getPassword ()
    {
        return $this->password;
    }

	
    
    /*
     * @see \Symfony\Component\Security\Core\User\UserInterface::getRoles()
    */
    public function getRoles ()
    {
        return array('ROLE_USER');
    }

	

	/* (non-PHPdoc)
     * @see \Symfony\Component\Security\Core\User\UserInterface::eraseCredentials()
     */
    public function eraseCredentials ()
    {
        //???
    }

    // ************************* End Interfaces *************************************
    

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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    
    // **************************** Advanced user interface ****************************
    
    public function isAccountNonExpired()
    {
        return true;
    }
    
    public function isAccountNonLocked()
    {
        return true;
    }
    
    public function isCredentialsNonExpired()
    {
        return true;
    }
    
    public function isEnabled()
    {
        return $this->isActive;
    }
    
    

    /**
     * Add blogs
     *
     * @param \Blogger\BlogBundle\Entity\Blog $blogs
     * @return User
     */
    public function addBlog(\Blogger\BlogBundle\Entity\Blog $blogs)
    {
        $this->blogs[] = $blogs;
    
        return $this;
    }

    /**
     * Remove blogs
     *
     * @param \Blogger\BlogBundle\Entity\Blog $blogs
     */
    public function removeBlog(\Blogger\BlogBundle\Entity\Blog $blogs)
    {
        $this->blogs->removeElement($blogs);
    }

    /**
     * Get blogs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBlogs()
    {
        return $this->blogs;
    }
    
    function __toString()
    {
        return $this->username;
    }
}