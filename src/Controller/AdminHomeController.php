<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(EntityManagerInterface $manager, ProductRepository $repo)
    {
        // Produit le plus commandé sur la semaine 
        $mostOrdered = $manager->createQuery(
            'SELECT COUNT(o) as total, p.productName,p.rightPic1Name,p.productDescription1,p.unitPrice,p.createdAt
            FROM App\Entity\Order o
            JOIN o.products p
            GROUP BY p 
            ORDER BY total DESC'
        )->setMaxResults(1)->getResult();

        // Tous les utilisateurs
        $users = $manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
        // Tous les commentaires
        $comments = $manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c')->getSingleScalarResult();
        // Tous les produits créés
        $products = $manager->createQuery('SELECT COUNT(p) FROM App\Entity\Product p')->getSingleScalarResult();
        // Toutes les commandes
        $orders = $manager->createQuery('SELECT COUNT(o) FROM App\Entity\Order o')->getSingleScalarResult();
        // Toutes les catégories
        $categories = $manager->createQuery('SELECT COUNT(ct) FROM App\Entity\Category ct')->getSingleScalarResult();

        // les 7 derniers produits et leurs ventes
        $seven = $manager->createQuery('SELECT p.id, p.productName,(100-(p.currentStock*100/p.initialStock)) as sales FROM App\Entity\Product p ORDER BY p.createdAt DESC')->setMaxResults(7)->getScalarResult();

        // Nombre de commandes par jour pour une semaine
            // Selectionner une periode
            $now = $manager->createQuery('SELECT p.createdAt FROM App\Entity\Product p WHERE p.id = 11')->getResult();

        return $this->render('admin/home/index.html.twig',[
            'stats' => compact('users','comments','products','orders','categories'),
            'seven' => $seven,
            'mostOrdered' => $mostOrdered
        ]);
    }
}
