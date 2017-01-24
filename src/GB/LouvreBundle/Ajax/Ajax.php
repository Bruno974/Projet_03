<?php
namespace GB\LouvreBundle\Ajax;

use Symfony\Component\HttpFoundation\Request;


use Doctrine\ORM\EntityManager;


class Ajax
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function milleBillets($date)
    {
        //Créer l'objet à partir de la date en argument
        $dateobj = new \DateTime($date);

        //Récupère le nombre de date correspondant à la date passée
        $reserve = $this->em->getRepository('GBLouvreBundle:Formulaire')->findBy(array('calendrier' => $dateobj));
        //Initialise un compteur
        $placePrise = 0;

        foreach ($reserve as $nbre) //Boucle sur le nombre de date, ex boucle 5 fois
        {
            foreach ($nbre->getVisiteurs() as $visiteurAj) // Boucle sur le nombre de visiteur dans une date
            {
                $placePrise++;
            }
        }

            return $valeur = 1000-$placePrise;

    }
}


