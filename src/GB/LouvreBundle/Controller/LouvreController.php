<?php
namespace GB\LouvreBundle\Controller;

use GB\LouvreBundle\Entity\Formulaire;
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

        $em = $this->getDoctrine()->getManager();
        $em->persist($formulaire);
        $em->flush();

        if($request->isMethod('POST'))
        {
            $request->getSession()->getFlashBag()->add('notice', 'Visite bien enregistrée');
            return $this->redirectToRoute('gb_louvre_recapitulatif', array('id' => $formulaire->getId()));
        }

        return $this->render('GBLouvreBundle:Louvre:formulaire.html.twig');
    }
}


