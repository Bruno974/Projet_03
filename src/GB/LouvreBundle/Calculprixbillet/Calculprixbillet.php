<?php
namespace GB\LouvreBundle\Calculprixbillet;

class Calculprixbillet
{
    public function calculPrix($visiteurAge, $formulaire)
    {
            $dateNaissanceVisiteur = $visiteurAge->getDateNaissance(); // récupère date naissance du visiteur
            $now = new \DateTime(); // créer la date du jour
            $age = $now->diff($dateNaissanceVisiteur)->y; //compare la date aujourd'hui et la date naissance et calcul la différence

            $prix = 16;
            $tarif = 'Tarif normal';


            if ($age < 4)
            {
                $prix = 0;
                $tarif = 'Gratuit';
            } elseif ($age >= 4 && $age <= 12)
            {
                $prix = 8;
                $tarif = 'Tarif enfant';
            } elseif ($age >= 60)
            {
                $prix = 12;
                $tarif = 'Tarif senior';
            }

            if($visiteurAge->getTarifReduit()) // Si la case Tarif réduit est cochée.
            {
                $prix = $prix-10;    //Rabait de 10 euros
                $tarif = "Tarif réduit";
            }

            //Hydrate prix
           $visiteurAge->setPrix($prix);
           //Calcul le total et hydrate total
           $formulaire->calculTotal($prix);
           //Hydrate tarif
           $visiteurAge->setTarif($tarif);
    }

}

