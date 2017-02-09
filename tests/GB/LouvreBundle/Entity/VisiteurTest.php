<?php

namespace Tests\GB\LouvreBundle\Entity;

use GB\LouvreBundle\Entity\Visiteur;

class VisiteurTest extends \PHPUnit_Framework_TestCase
{
    public function testSetNom()
    {
        $visiteur = new Visiteur();
        $nom = 'Dupont';
        $visiteur->setNom($nom);
        $this->assertEquals('Dupont', $visiteur->getNom());
    }

    public function testSetPrenom()
    {
        $visiteur = new Visiteur();
        $prenom = 'Jean';
        $visiteur->setPrenom($prenom);
        $this->assertEquals('Jean', $visiteur->getPrenom());
    }

    public function testSetPays()
    {
        $visiteur = new Visiteur();
        $pays = 'France';
        $visiteur->setPays($pays);
        $this->assertEquals('France', $visiteur->getPays());
    }

}

