<?php 

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        $blogs = $em->createQueryBuilder()
                ->select('b')
                ->from('BloggerBlogBundle:Blog', 'b')
                ->addOrderBy('b.created', 'DESC')
                ->getQuery()
                ->getResult();
        
        
        return $this->render('BloggerBlogBundle:Page:index.html.twig', array('blogs' => $blogs)); 
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
            
            if ($form->isValid()){
                
               $message = \Swift_Message::newInstance();
               $message->setSubject('Contact enquiry from sfblog')
                       ->setFrom('enquiries@blah.com')
                       ->setTo( $this->container->getParameter('blogger_blog.emails.contact_email')  )
                       ->setBody( $this->renderView('BloggerBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry))  );
               
               $this->get('mailer')->send($message);
               
               $this->get('session')->setFlash('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');

                return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));
            }
            
        }
        
        
        
        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
                'form' => $form->createView()
        ));
    }
}
