<?php

namespace Tests\GB\LouvreBundle\Entity;

use GB\LouvreBundle\Entity\Formulaire;


class FormulaireTest extends \PHPUnit_Framework_TestCase
{
    public function testSetMail()
    {
        $formulaire = new Formulaire();
        $mail = 'gont.bruno@gmail.com';
        $formulaire->setMail($mail);
        $this->assertEquals('gont.bruno@gmail.com', $formulaire->getMail());
    }

    public function testCalculTotal()
    {
        $formulaire = new Formulaire();
        $prix1 = 8;
        $prix2 = 16;
        $formulaire->calculTotal($prix1);
        $formulaire->calculTotal($prix2);
        $this->assertEquals(24, $formulaire->getTotal());
    }

}



