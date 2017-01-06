<?php
namespace GB\LouvreBundle\Controller;

use GB\LouvreBundle\Entity\Formulaire;
use GB\LouvreBundle\Entity\Visiteur;
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
        $formulaire->setDuree(1);
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


        $em = $this->getDoctrine()->getManager();
        $em->persist($formulaire);
        $em->persist($visiteur1);
        $em->persist($visiteur2);
        $em->flush();

        if($request->isMethod('POST'))
        {
            $request->getSession()->getFlashBag()->add('notice', 'Visite bien enregistrée');
            return $this->redirectToRoute('gb_louvre_recapitulatif', array('id' => $formulaire->getId()));
        }

        return $this->render('GBLouvreBundle:Louvre:formulaire.html.twig');
    }
}


