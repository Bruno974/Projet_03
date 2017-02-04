<?php

namespace Tests\GB\LouvreBundle\Calculprixbillet;

use GB\LouvreBundle\Calculprixbillet;
use GB\LouvreBundle\Entity\Formulaire;
use GB\LouvreBundle\Entity\Visiteur;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalculprixbilletTest extends WebTestCase
{
    private $client;
    private $calcul;

    protected function setUp() {

        $this->client = self::createClient();
        $container = $this->client->getContainer();
        $this->calcul = $container->get('gb_louvre.calculprixbillet');
    }

    public function testCalculPrix()
    {
        //calculPrix($visiteurAge, $formulaire)
        $visiteur = new Visiteur();
        $visiteur->setDateNaissance(new \Datetime('1982-09-20'));
        $visiteur->setTarifReduit(false);

        $formulaire = new Formulaire();
        $formulaire->setCalendrier(new \Datetime('2017-02-05'));

        $result = $this->calcul->calculPrix($visiteur, $formulaire);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(16, $result);
    }
}


//$calc = new Calculprixbillet();
//$form = new Formulaire()


