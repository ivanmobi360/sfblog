<?php

namespace Blogger\BlogBundle\Controller;

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
     * @Route("/hello", defaults={"name"="World"}),
     * @Route("/hello/{name}", name="_admin_hello")
     * @Template()
     */
    public function helloAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/post/new", name="new_post")
     * @Template()
     */
    public function newPostAction()
    {
        $form = $this->createForm(new BlogType());
        
        return array('form'=> $form->createView());
    }
    
    /**
     * @Route("/post/create", name="create_post")
     * @Template()
     */
    public function createPostAction()
    {
        $form = $this->createForm(new BlogType());
    
        return array('form'=> $form->createView());
    }
    
}
