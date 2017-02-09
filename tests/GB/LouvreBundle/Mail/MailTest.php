<?php
/*
namespace Tests\GB\LouvreBundle\Mail;

use GB\LouvreBundle\Calculprixbillet;
use GB\LouvreBundle\Entity\Formulaire;
use GB\LouvreBundle\Entity\Visiteur;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MailTest extends WebTestCase
{
   // private $client;
   // private $calcul;

  /*  protected function setUp() {

        $this->client = self::createClient();
        $container = $this->client->getContainer();
        $this->calcul = $container->get('gb_louvre.mail');
    }*/

 /*   public function testMailIsSentAndContentIsOk()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/path/to/above/action');
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertEquals(1, $mailCollector->getMessageCount());
        //calculPrix($visiteurAge, $formulaire)
       /* $visiteur = new Visiteur();
        $visiteur->setDateNaissance(new \Datetime('1982-09-20'));
        $visiteur->setTarifReduit(false);*/
        /*$this->client->enableProfiler();
        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');
        $this->assertEquals(1, $mailCollector->getMessageCount());

        $formulaire = new Formulaire();
        $formulaire->setCalendrier(new \Datetime('2017-02-05'));
        $formulaire->setMail('gont.bruno@gmail.com');

        $result = $this->calcul->mail($formulaire);

        $this->assertEquals(1, $result);

       $collectedMessages = $this->calcul->getMessages();
        $message = $collectedMessages[0];

        // Asserting email data
        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertEquals('Hello Email', $message->getSubject());
        $this->assertEquals('send@example.com', key($message->getFrom()));
        $this->assertEquals('recipient@example.com', key($message->getTo()));
        $this->assertEquals(
            'You should see me from the profiler!',
            $message->getBody());

        // assert that your calculator added the numbers correctly!
        //$this->assertEquals(16, $result);
    }
}*/


