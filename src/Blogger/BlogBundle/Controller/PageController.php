<?php 

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('BloggerBlogBundle:Page:index.html.twig'); 
    }
    
    public function aboutAction()
    {
        return $this->render('BloggerBlogBundle:Page:about.html.twig');
    }
    
    public function contactAction()
    {
        $enquiry = new \Blogger\BlogBundle\Entity\Enquiry();
        $form = $this->createForm(new \Blogger\BlogBundle\Form\EnquiryType(), $enquiry);
        
        $request = $this->getRequest();
        if ( 'POST' ==  $request->getMethod()){
            $form->bindRequest($request);
            
            if($form->isValid()){
                
                return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));
            }
            
        }
        
        
        
        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
                'form' => $form->createView()
        ));
    }
}
