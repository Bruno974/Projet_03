<?php
namespace GB\LouvreBundle\Controller;

use GB\LouvreBundle\Entity\Formulaire;
use GB\LouvreBundle\Entity\Visiteur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $formulaire);
        $formBuilder
            ->add('calendrier', DateType::class)
            ->add('duree', ChoiceType::class, array('choices' => array(
                'Journee' => '1',
                'Demi-journee' => '2'),
                'multiple'=>false,'expanded'=>true))
            ->add('mail', EmailType::class)
            ->add('Valider', SubmitType::class);
        $form = $formBuilder->getForm();

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($formulaire);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Visite bien enregistrée');
                return $this->redirectToRoute('gb_louvre_recapitulatif', array('id' => $formulaire->getId()));
            }
        }

        return $this->render('GBLouvreBundle:Louvre:formulaire.html.twig', array('form' => $form->createView()));
        /*$formulaire->setDuree(1);
        $formulaire->setMail('gont@gmail.com');

        $visiteur1 = new Visiteur();
        $visiteur1->setDateNaissance(new \DateTime());
        $visiteur1->setNom('gonthier');
        $visiteur1->setPrenom('bruno');
        $visiteur1->setPays('france');
        $visiteur1->setTarifReduit('1');

        $visiteur2 = new Visiteur();
        $visiteur2->setDateNaissance(new \DateTime());
        $visiteur2->setNom('john');
        $visiteur2->setPrenom('john');
        $visiteur2->setPays('france');
        $visiteur2->setTarifReduit('0');

        $formulaire->addVisiteur($visiteur1);
        $formulaire->addVisiteur($visiteur2);
*/

        //$em = $this->getDoctrine()->getManager();
       /* $em->persist($formulaire);
        $em->persist($visiteur1);
        $em->persist($visiteur2);
        $em->flush();*/

      /*  if($request->isMethod('POST'))
        {
            $request->getSession()->getFlashBag()->add('notice', 'Visite bien enregistrée');
            return $this->redirectToRoute('gb_louvre_recapitulatif', array('id' => $formulaire->getId()));
        }

        return $this->render('GBLouvreBundle:Louvre:formulaire.html.twig');*/
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




