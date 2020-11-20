<?php

namespace App\Controller;

use App\Services\Cart\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/cart", name="cart_index")
     */
    public function index(CartService $cartservice)
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartservice->getFullCart(),
            'total' => $cartservice->getTotal(),
            'user'=> $this->getUser()
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function addToCart($id,CartService $cartservice)
    {
        $cartservice->add($id);
        return $this->redirectToRoute("cart_index");
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id,CartService $cartservice)
    {
        $cartservice->remove($id);
        return $this->redirectToRoute("cart_index");
    }
}
