<?php

namespace App\Services\Payment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PaymentService {
    protected $request;
    protected $session;

    public function __construct(SessionInterface $session, Request $request)
    {
        $this->session = $session;
    }

    // fonction d'ajout des elements de la form Checkout dans la session 

    public function formCheckout($form,$request)
    {
        $ShippingCity = $this->session->get('ShippingCity',[]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->session->set('ShippingCity',$form->get('ShippingCity'));
        }

    }
}
