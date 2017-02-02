<?php
namespace GB\LouvreBundle\Controller;

use GB\LouvreBundle\Entity\Formulaire;
use GB\LouvreBundle\Entity\Visiteur;
use GB\LouvreBundle\Form\FormulaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class LouvreController extends Controller
{
    /*-----------------------------Pour la page d'accueil----------------------------*/
    public function accueilAction()
    {
        return $this->render('GBLouvreBundle:Louvre:accueil.html.twig');
    }

    /*-------------------------Pour l'ajax ds le formulaire--------------------------------*/
    public function ajaxAction(Request $request, $date)
    {
        //Récupére le nombre de place restant grâce aux services
        $placePrise = $this->get('gb_louvre.ajax')->milleBillets($date);

        if ($request->isXmlHttpRequest())
        {
            return new Response($placePrise);
        }
        return new Response('Problème avec Ajax', 400);
    }

    /*-------------------------------Pour le formulaire---------------------------------------------*/
    public function formulaireAction(Request $request)
    {
        $formulaire = new Formulaire();

        $form = $this->get('form.factory')->create(FormulaireType::class, $formulaire);

        //$form->handleRequest($request);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) //($request->isMethod('POST') && ($form->isValid()))
        {
            //Récupére toutes les informations du formulaire visiteur et les liés au formulaire.
            foreach ($form->get('visiteurs')->getData() as $visiteur)
            {
                $formulaire->addVisiteur($visiteur);//lie le formulaire aux visiteurs
                $this->get('gb_louvre.calculprixbillet')->calculPrix($visiteur, $formulaire); //Utilisation du service pour calculer le prix du billet selon l'age
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($formulaire);
            $em->flush();
            return $this->redirectToRoute('order_prepare', array('id' => $formulaire->getId()));
        }
        return $this->render('GBLouvreBundle:Louvre:formulaire.html.twig', array('form' => $form->createView()));
    }


    /*----------------------------------Pour le récapitulatif----------------------------------*/
    public function paiementAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $formulaire = $em->getRepository('GBLouvreBundle:Formulaire')->find($id);

        $listVisiteurs = $em->getRepository('GBLouvreBundle:Visiteur')->findBy(array('formulaire' => $formulaire));
        $calendrier = $formulaire->getCalendrier(); //Récupére la date
        $date = $calendrier->format('d-m-Y'); //formate la date en string
        return $this->render('GBLouvreBundle:Louvre:prepare.html.twig', array(
            'formulaires' => $formulaire,
            'listVisiteur' => $listVisiteurs,
            'date' => $date
        ));

    }

    /*-----------------------------------Pour stripe---------------------------------*/
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
        return $this->redirectToRoute("gb_louvre_recapitulatif");
    }


    /*---------------------------------Pour la confirmation---------------------------------*/
    public function recapitulatifAction()
    {
        return $this->render('GBLouvreBundle:Louvre:recapitulatif.html.twig');
    }
}





