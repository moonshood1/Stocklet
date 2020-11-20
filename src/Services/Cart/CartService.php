<?php

namespace App\Services\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    protected $session;
    protected $productrepository;

    public function __construct(SessionInterface $session, ProductRepository $productrepository)
    {
        $this->session = $session;
        $this->productrepository = $productrepository;
    }

    // Fonction d'ajout au panier
    public function add($id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    // Fonction de suppression des elements du panier
    public function remove($id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier',$panier);
    }

    // Fonction de recuperation des éléments du panier
    public function getFullCart(): array
    {
        $panier = $this->session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $this->productrepository->find($id),
                'quantity'=> $quantity 
            ];
        }
        return $panierWithData;

    }

    // Fonction pour vider totalement le panier
    public function clearCart()
    {
        $panier = $this->session->get('panier', []);
        $panierVide = [];

        if (!empty($panier)) {
            
            $this->session->set('panier',$panierVide);
        }
    }

    // Fonction pour calculer le montant total du panier
    public function getTotal(): float 
    {
        $total = 0;

        foreach ($this->getFullCart() as $item) {
            $total += $item['product']->getUnitPrice()*$item['quantity'];
        }

        return $total;
    }


}


?>