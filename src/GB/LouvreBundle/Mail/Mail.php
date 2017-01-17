<?php
namespace GB\LouvreBundle\Mail;

use Symfony\Component\Templating\EngineInterface;

class Mail
{
     protected $mailer;
     protected $templating;

     public function __construct(\Swift_Mailer $mailer, $templating)
     {
         $this->mailer = $mailer;
         $this->templating = $templating; //Pour pouvoir utiliser le render
     }

     public function mail($form)
     {
$age= 10;
         $message = \Swift_Message::newInstance()
             ->setSubject('Confirmation de réservation des billets')
             ->setFrom('gont.bruno@gmail.com')
             ->setTo($form->getMail())
             ->setContentType('text/html') //évite d'avoir du code html ds le mail
             ->setBody(
                $this->templating->render('@GBLouvre/Louvre/email.html.twig', array('prenom' => $age))
             );

         $this->mailer->send($message);
     }
}

