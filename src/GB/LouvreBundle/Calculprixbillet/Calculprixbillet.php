<?php
namespace GB\LouvreBundle\Calculprixbillet;

class Calculprixbillet
{
    public function calculPrix($visiteurAge, $formulaire)
    {
            $dateNaissanceVisiteur = $visiteurAge->getDateNaissance(); // récupère date naissance du visiteur

           /*A réfléchir mais il faut récupérer la date choisi pour le calcul*/
          //  $now = new \DateTime(); // créer la date du jour
        $now = $formulaire->getCalendrier();
        var_dump($now);
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

            //étudiant, employé du musée, d’un service du Ministère de la Culture, militaire, personne age supérieur 12 ans

            if($visiteurAge->getTarifReduit() && $prix == 16) // Si la case Tarif réduit est cochée et que la personne à le plein tarif
            {
                $prix = 10;    //Prix billet de 10 euros
                $tarif = "Tarif réduit";
            }
            elseif ($visiteurAge->getTarifReduit() && $prix == 12) // Si la case Tarif réduit est cochée et que la personne à le tarif sénior
            {
                $prix = 10;    //Prix billet de 10 euros
                $tarif = "Tarif réduit";
            }

            if($formulaire->getDuree() == 2) //Si la case demi-journée est cochée on divisie le prix par 2
            {
                $prix = $prix/2;
            }

            //Hydrate prix
           $visiteurAge->setPrix($prix);
           //Calcul le total et hydrate total
           $formulaire->calculTotal($prix);
           //Hydrate tarif
           $visiteurAge->setTarif($tarif);
    }

}

