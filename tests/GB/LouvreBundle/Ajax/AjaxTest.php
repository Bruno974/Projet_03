<?php

namespace Tests\GB\LouvreBundle\Ajax;

use GB\LouvreBundle\Calculprixbillet;
use GB\LouvreBundle\Entity\Formulaire;
use GB\LouvreBundle\Entity\Visiteur;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AjaxTest extends WebTestCase
{
    private $client;
    private $ajax;

    protected function setUp() {

        $this->client = self::createClient();
        $container = $this->client->getContainer();
        $this->ajax = $container->get('gb_louvre.ajax');
    }

    public function testMilleBillets()
    {
        $result = $this->ajax->milleBillets('2017-03-17');  //A ce jour, il y a 997 places de disponible

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(999, $result);
    }
}


//pour test vendor/bin/phpunit