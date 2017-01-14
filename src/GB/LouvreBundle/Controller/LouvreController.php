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
            $em->persist($formulaire);
            $em->flush();
            return $this->redirectToRoute('order_prepare', array('id' => $formulaire->getId()));  //gb_louvre_recapitulatif
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

    public function checkoutAction($total)
    {

        $test=$this->get('gb_louvre.stripe')->stripe($total);
        /*-------------Gérer les messages flash selon le peiement---------------*/
        if($test === 1)
        {
            $this->addFlash("success","Paiement accepté");
            /*--------------Envoie d'un email--------------------------------------------------------------------*/
            $age = "Test de age";
            $message = \Swift_Message::newInstance()
                ->setSubject('Confirmation de réservation des billets')
                ->setFrom('cerveza_974@hotmail.com')
                ->setTo('gont.bruno@gmail.com')
                ->setBody(
                    $this->renderView('@GBLouvre/Louvre/email.html.twig', array('prenom' => $age)),
                    'text/html'
                );
            $this->get('mailer')->send($message);
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


/*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'Emails/registration.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        )
        */




