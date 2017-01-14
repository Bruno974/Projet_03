<?php

namespace GB\LouvreBundle\Stripe;


class Stripe
{
    public function stripe($total)
    {
        \Stripe\Stripe::setApiKey("sk_test_19YRLxBnf8HI9TP6lo1BVN9M");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" =>$total*100 , // Amount est en cents, multiplie par 100 pour euros et se sera prix qui sera facturé
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe - Louvre"
            ));

           return 1;//$this->addFlash("success","Bravo ça marche !");
            //return $this->redirectToRoute("gb_louvre_accueil");
        } catch(\Stripe\Error\Card $e) {

           return 2;// $this->addFlash("error","Snif ça marche pas :(");
            //return $this->redirectToRoute("order_prepare");
            // The card has been declined
        }
    }
}

