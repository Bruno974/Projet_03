<?php
namespace GB\LouvreBundle\Controller;

use GB\LouvreBundle\Entity\Formulaire;
use GB\LouvreBundle\Entity\Visiteur;
use GB\LouvreBundle\Form\FormulaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


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
                $prenom = $visiteur->getPrenom();
                //$age = $visiteur->getDateNaissance()->format('Y-m-d');
                $formulaire->addVisiteur($visiteur);//lie
            }
            /*-------------------------------------------------------------------------------------------------------*/

            /*--------------------Calcul age--------------------------------------------------------------------------*/
            $visiteurAjoutes = $formulaire->getVisiteurs();

            foreach ($form->get('visiteurs')->getData() as $visiteurAge)
            {
                $dateNaissanceVisiteur = $visiteurAge->getDateNaissance();
                $now = new \DateTime();
                $age = $now->diff($dateNaissanceVisiteur)->y;
                var_dump($age);
                echo $age;
            }
            /*--------------------------------------------------------------------------------------------------------*/


            $em = $this->getDoctrine()->getManager();
            $em->persist($formulaire);
            $em->flush();

            /*--------------Envoie d'un email--------------------------------------------------------------------*/

            $message = \Swift_Message::newInstance()
                ->setSubject('Confirmation de réservation des billets')
                ->setFrom('cerveza_974@hotmail.com')
                ->setTo('gont.bruno@gmail.com')
                ->setBody(
                    $this->renderView('@GBLouvre/Louvre/email.html.twig', array('prenom' => $age)),
                    'text/html'
                //$nom['nom']
                )
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
            ;
            $this->get('mailer')->send($message);
            /*--------------------------------------------------------------------------------------------------------*/


            $request->getSession()->getFlashBag()->add('notice', 'Visite bien enregistrée');
            return $this->redirectToRoute('gb_louvre_recapitulatif', array('id' => $formulaire->getId()));
        }



        return $this->render('GBLouvreBundle:Louvre:formulaire.html.twig', array('form' => $form->createView()));
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




