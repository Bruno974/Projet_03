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
            /*--------------Recupere email----------------*/
            $nom = $form->get('visiteurs')->getData();

            $message = \Swift_Message::newInstance()
                ->setSubject('Hello Email')
                ->setFrom('cerveza_974@hotmail.com')
                ->setTo('gont.bruno@gmail.com')
                ->setBody(
                   /* $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'Emails/registration.html.twig',
                        array('name' => $name)
                    ),
                    'text/html'*/
                   $nom
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






            //Récupére toutes les informations du formulaire visiteur.
            foreach ($form->get('visiteurs')->getData() as $visiteur)
            {
                $formulaire->addVisiteur($visiteur);//lie
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($formulaire);
            $em->flush();


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




