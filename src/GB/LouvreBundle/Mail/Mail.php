<?php
namespace GB\LouvreBundle\Mail;

class Mail
{
     private $mailer;

     public function __construct(\Swift_Mailer $mailer)
     {
         $this->mailer = $mailer;
     }

     public function mail()
     {

         $message = \Swift_Message::newInstance()
             ->setSubject('Confirmation de réservation des billets')
             ->setFrom('cerveza_974@hotmail.com')
             ->setTo('gont.bruno@gmail.com')
             ->setBody(
                 $this->renderView('@GBLouvre/Louvre/email.html.twig', array('prenom' => $age)),
                 'text/html'
             //$nom['nom']
             )
             /*
              * If you also want to include a plaintext version of the message
             ->addPart(
                 $this->renderView(
                     'Emails/registration.txt.twig',
                     array('name' => $name)
                 ),
                 'text/plain'
             )
             */
         ;
         $this->get('mailer')->send($message);
     }
}

