<?php
namespace GB\LouvreBundle\Calculprixbillet;

class Calculprixbillet
{
    public function calculPrix($visiteurAge, $formulaire)
    {
        //foreach ($form->get('visiteurs')->getData() as $visiteurAge)
        //{
            $dateNaissanceVisiteur = $visiteurAge->getDateNaissance(); // récupère date naissance du visiteur
            $now = new \DateTime(); // créer la date du jour
            $age = $now->diff($dateNaissanceVisiteur)->y; //compare la date aujourd'hui et la date naissance et calcul la différence

            $prix = 16;
            $tarif = 'Tarif normal';


            if ($age <= 4)
            {
                $prix = 0;
                $tarif = 'Tarif enfant';
            } elseif ($age > 4 && $age < 12)
            {
                $prix = 8;
                $tarif = 'Tarif ado';
            } elseif ($age > 60)
            {
                $prix = 12;
                $tarif = 'Tarif vieux';
            }

            //Hydrate prix
           $visiteurAge->setPrix($prix);
           //Calcul le total et hydrate total
           $formulaire->calculTotal($prix);
           //Hydrate tarif
           $visiteurAge->setTarif($tarif);
    }

    public function calculTotal($id)
    {
       // $valeur = $em->getRepository()->findAll(formulaire_id);
    }
}

