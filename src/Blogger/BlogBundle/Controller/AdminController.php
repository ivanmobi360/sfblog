<?php

namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Helpers\Utils;

use Blogger\BlogBundle\Entity\Blog;

use Blogger\BlogBundle\Form\BlogType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/login", name="_login")
     * @Template()
     */
    public function loginAction()
    {
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );
    }

    /**
     * @Route("/login_check", name="_login_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/", name="admin_home")
     * @Template()
     */
    public function homeAction()
    {
        
        Utils::log( __METHOD__ . " ". print_r($_SESSION, true));
        
        return array('name' => $this->getUser()->getUsername());
    }

    /**
     * @Route("/post/new", name="new_post")
     * @Template()
     */
    public function newPostAction()
    {
        $form = $this->createBlogForm(new Blog());
        
        return array('form'=> $form->createView());
    }
    
    protected function createBlogForm($blog){
        return $this->createFormBuilder($blog)
        ->add('title')
        ->add('blog', 'textarea')
        ->add('file', null, array('label'=>'Image'))
        ->add('tags', 'text')
        ->getForm();
    }
    
    
    /**
     * @Route("/post/create", name="create_post")
     * @Template("BloggerBlogBundle:Admin:newPost.html.twig")
     */
    public function createPostAction()
    {
        
        $blog = new Blog();
        $blog->setUser($this->getUser());
        $request = $this->getRequest();
        $form = $this->createBlogForm($blog);
        $form->bindRequest($request);
        
        if($form->isValid()){
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($blog);
            $em->flush();
            
            return $this->redirect($this->generateUrl('BloggerBlogBundle_blog_show', array(
                    'id' => $blog->getId(),
                    'slug' => $blog->getSlug()
                    )));
            
        }
        
    
        return array('form'=> $form->createView());
    }
    
}
