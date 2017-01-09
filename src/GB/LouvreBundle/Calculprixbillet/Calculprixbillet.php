<?php
namespace GB\LouvreBundle\Calculprixbillet;

class Calculprixbillet
{
    public function calculPrix($visiteurAge)
    {
        //foreach ($form->get('visiteurs')->getData() as $visiteurAge)
        //{
            $dateNaissanceVisiteur = $visiteurAge->getDateNaissance(); // récupère date naissance du visiteur
            $now = new \DateTime(); // créer la date du jour
            $age = $now->diff($dateNaissanceVisiteur)->y; //compare la date aujourd'hui et la date naissance et calcul la différence

            $prix = 16;

            if ($age <= 4)
            {
                $prix = 0;
            } elseif ($age > 4 && $age < 12)
            {
                $prix = 8;
            } elseif ($age > 60)
            {
                $prix = 12;
            }
           $visiteurAge->setPrix($prix);
           // return $prix;
        //}
    }
}

