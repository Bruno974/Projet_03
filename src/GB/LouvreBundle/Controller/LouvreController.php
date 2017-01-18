<?php
namespace GB\LouvreBundle\Controller;

use GB\LouvreBundle\Entity\Formulaire;
use GB\LouvreBundle\Entity\Visiteur;
use GB\LouvreBundle\Form\FormulaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class LouvreController extends Controller
{
    public function accueilAction()
    {
        return $this->render('GBLouvreBundle:Louvre:accueil.html.twig');
    }

    public function formulaireAction(Request $request)
    {
        $formulaire = new Formulaire();

        $form = $this->get('form.factory')->create(FormulaireType::class, $formulaire);

        $form->handleRequest($request);
        if ($request->isMethod('POST') && ($form->isValid()))
        {
            //Récupére toutes les informations du formulaire visiteur et les liés au formulaire.
            foreach ($form->get('visiteurs')->getData() as $visiteur)
            {
                $formulaire->addVisiteur($visiteur);//lie le formulaire aux visiteurs
                $this->get('gb_louvre.calculprixbillet')->calculPrix($visiteur, $formulaire); //Utilisation du service pour calculer le prix du billet selon l'age
            }

            $em = $this->getDoctrine()->getManager();
            /*------------Test--------------------------*/

            $placePrise = 0;
            $dateJour = $form->get('calendrier')->getData(); //Récupére la date sélectionner ds le formulaire
            $nombreIds = $em->getRepository('GBLouvreBundle:Formulaire')->findBy(array('calendrier' => $dateJour)); //Récupére les données à partir de cette date,  exemple recup 5 date et tou ces données
            foreach ($nombreIds as $nbre) //Boucle sur le nombre de date, ex boucle 5 fois
            {
                foreach ($nbre->getVisiteurs() as $visiteurAj) // Boucle sur le nombre de visiteur dans une date
                {
                    $placePrise ++;
                }
            }
            var_dump($placePrise);
            /*---------------------------------------*/

            $em->persist($formulaire);
            $em->flush();
            return $this->redirectToRoute('order_prepare', array('id' => $formulaire->getId())/*, array('test' => $placePrise)*/);  //gb_louvre_recapitulatif
        }
        return $this->render('GBLouvreBundle:Louvre:formulaire.html.twig', array('form' => $form->createView()));
    }

    public function paiementAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $formulaire = $em->getRepository('GBLouvreBundle:Formulaire')->find($id);

        $listVisiteurs = $em->getRepository('GBLouvreBundle:Visiteur')->findBy(array('formulaire' => $formulaire));

        return $this->render('GBLouvreBundle:Louvre:prepare.html.twig', array(
            'formulaires' => $formulaire,
            'listVisiteur' => $listVisiteurs
        ));

    }

    public function checkoutAction($id)
    {
        $form = $this->getDoctrine()->getManager()->getRepository('GBLouvreBundle:Formulaire')->find($id);
        $test=$this->get('gb_louvre.stripe')->stripe($form->getTotal());

        /*-------------Gérer les messages flash selon le peiement---------------*/
        if($test === 1)
        {
            $this->addFlash("success","Paiement accepté");
            /*--------------Envoie d'un email--------------------------------------------------------------------*/
            $this->get('gb_louvre.mail')->mail($form);
            /*--------------------------------------------------------------------------------------------------------*/
        }
        else
        {
            $this->addFlash("success","Paiement refusé");
        }
        return $this->redirectToRoute("gb_louvre_accueil");
    }


    public function recapitulatifAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $formulaire = $em->getRepository('GBLouvreBundle:Formulaire')->find($id);

        $listVisiteurs = $em->getRepository('GBLouvreBundle:Visiteur')->findBy(array('formulaire' => $formulaire));

        return $this->render('GBLouvreBundle:Louvre:recapitulatif.html.twig', array(
            'formulaires' => $formulaire,
            'listVisiteur' => $listVisiteurs
        ));
    }
}





