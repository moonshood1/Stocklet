<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\CheckoutType;
use App\Services\Cart\CartService;
use App\Services\Mailer\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/checkout", name="checkout_index")
     */
    public function index(CartService $cartservice,Request $request)
    {
            // Création de la nouvelle commande au clique sur le formulaire de commande

            $order = new Order();
            $form = $this->createForm(CheckoutType::class, $order);
            $form->handleRequest($request);
            $session = $request->getSession();
            
            if ($form->isSubmitted() && $form->isValid()) {
                $shippingCity = $request->request->get('checkout')['shippingCity'];
                $shippingDistrict = $request->request->get('checkout')['shippingDistrict'];
                $shippingAddress1 = $request->request->get('checkout')['shippingAddress1'];
                $shippingAddress2 = $request->request->get('checkout')['shippingAddress2'];

                $session->set('shippingCity',$shippingCity);
                $session->set('shippingDistrict',$shippingDistrict);
                $session->set('shippingAddress1',$shippingAddress1);
                $session->set('shippingAddress2',$shippingAddress2);
                $session->set('invoiceNumber',sha1(mt_rand(1, 200) . 'SALT').'-'.date('Y').'-'.date('m').'-'.$this->getUser()->getId());

                return $this->redirectToRoute("payment_index");
            }; 

             return $this->render('checkout/index.html.twig', [
            'form' => $form->createView(),
            'product' => $cartservice->getFullCart()[0]['product'],
            'total' => $cartservice->getTotal(),
            'qty' => $cartservice->getFullCart()[0]['quantity'],
            'user'=>$this->getUser()
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/checkout-payment", name="payment_index")
     *
     * @param CartService $cartservice
     * @return void
     */
    public function payment(CartService $cartservice)
    {
        return $this->render('checkout/payment.html.twig', [
            'product' => $cartservice->getFullCart()[0]['product'],
            'total' => $cartservice->getTotal(),
            'qty' => $cartservice->getFullCart()[0]['quantity'],
            'user'=> $this->getUser(),
        ]);
    }


    /**
     * @IsGranted("ROLE_USER")
     * @Route("/checkout-confirm", name="confirmation_index")
     * @param CartService $cartservice
     * @return void
     */
    public function confirm(CartService $cartservice,Request $request) 
    {
        $session = $request->getSession();

        $shippingCity = $session->get('shippingCity');
        $shippingDistrict = $session->get('shippingDistrict');
        $shippingAddress1 = $session->get('shippingAddress1');
        $shippingAddress2 = $session->get('shippingAddress2');


        return $this->render('checkout/confirmation.html.twig', [
            'product' => $cartservice->getFullCart()[0]['product'],
            'total' => $cartservice->getTotal(),
            'qty' => $cartservice->getFullCart()[0]['quantity'],
            'user'=>$this->getUser(),
            'city' => $shippingCity,
            'district' => $shippingDistrict,
            'adresse1' => $shippingAddress1,
            "adresse2" => $shippingAddress2
        ]);
    }

    /**
     * @Route("/checkout-failed", name="checkout_failed")
     * @param CartService $cartservice
     */
    public function failed(CartService $cartservice)
    {
        $this->addFlash('error',"Un problème est survenu pendant votre paiement, nous vous prions de verifier le solde de votre wallet ou de réessayer");
        return $this->render('checkout/failed.html.twig', [
            'product' => $cartservice->getFullCart()[0]['product'],
            'total' => $cartservice->getTotal(),
            'qty' => $cartservice->getFullCart()[0]['quantity'],
            'user'=> $this->getUser(),
        ]);        
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/finalisation", name="order_confirmed")
     */
    public function final(CartService $cartservice,Request $request,EntityManagerInterface $manager,MailerService $mailerService)
    {
        // Initialisation de la session  et du stock actuel
        $session = $request->getSession();
        $currentStock = $cartservice->getFullCart()[0]['product']->getCurrentStock();

        // Appel du chrono pour le numéro de facture du client
        $chrono = $this->getUser()->getChrono();

        // Creation de la commande et attribution des différentes valeurs
        $order = new Order();
        $order->setProductQuantity($cartservice->getFullCart()[0]['quantity'])
              ->setProductUnitPrice($cartservice->getFullCart()[0]['product']->getUnitPrice())
              ->setOrderTotalAmount($cartservice->getTotal())
              ->setProducts($cartservice->getFullCart()[0]['product'])
              ->setUsers($this->getUser())
              ->setShippingCity($session->get('shippingCity'))
              ->setShippingDistrict($session->get('shippingDistrict'))
              ->setShippingAddress1($session->get('shippingAddress1'))
              ->setShippingAddress2($session->get('shippingAddress2'))
              ->setInvoiceNumber($session->get('invoiceNumber'));

        $manager->persist($order);

        // Mise a jour du stock apres la validation
        $product = $cartservice->getFullCart()[0]['product'];
        $product->setCurrentStock($currentStock - $cartservice->getFullCart()[0]['quantity']);       
        $manager->flush();
        
        // On vide le panier apres commande
        $cartservice->clearCart();

        // Envoi du mail à la fin de la commande 
        $mailerService->sendOrderDetails(
            $this->getUser()->getEmail(),
            $order,$session->get('invoiceNumber'),
            $this->getUser()->getFirstName(),
            $this->getUser()->getLastName());


        return $this->redirectToRoute("home");
    }

    /**
     * @Route("/payment/process" , name="payment_process")
     *
     * @return Response
     */
    public function sendData(CartService $cartservice,Request $request)
    {  
        $session = $request->getSession();

        $shopId = "5dea9f276f0d90123988ed74";
        $amount = $cartservice->getTotal();
        $customerNumber = $this->getUser()->getId();
        $orderNumber = $session->get('invoiceNumber');
        $secret = "RoJv4p2xL7L8H6XLUQbpSqbE";
        $signature = $shopId.';'.$amount.';'.$secret;
        $trash = md5($signature);
        $hash = strtoupper($trash);

        return $this->json([
            'shopId' => $shopId,
            'amount'=> $amount,
            'customerNumber'=> $customerNumber,
            'orderNumber' => $orderNumber,
            'signature' => $hash
        ],200);
    }
}
