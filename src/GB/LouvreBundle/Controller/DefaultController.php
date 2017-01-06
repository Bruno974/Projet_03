<?php

namespace GB\LouvreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GBLouvreBundle:Default:index.html.twig');
    }
}
