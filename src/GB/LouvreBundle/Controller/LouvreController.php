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
                $age = $visiteur->getDateNaissance()->format('Y-m-d');

                $formulaire->addVisiteur($visiteur);//lie le formulaire aux visiteurs
                $this->get('gb_louvre.calculprixbillet')->calculPrix($visiteur); //Utilisation du service pour calculer le prix du billet selon l'age

            }
            /*-------------------------------------------------------------------------------------------------------*/

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

    public function paiementAction()
    {
        return $this->render('GBLouvreBundle:Louvre:prepare.html.twig');
    }

    public function checkoutAction()
    {

        \Stripe\Stripe::setApiKey("sk_test_19YRLxBnf8HI9TP6lo1BVN9M");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => 1500, // Amount in cents  //prix qui sera facturé
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe - OpenClassrooms Exemple"
            ));
            $this->addFlash("success","Bravo ça marche !");
            return $this->redirectToRoute("order_prepare");
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Snif ça marche pas :(");
            return $this->redirectToRoute("order_prepare");
            // The card has been declined
        }
    }
}




