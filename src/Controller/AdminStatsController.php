<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminStatsController extends AbstractController
{
    /**
     * @Route("/admin/stats", name="admin_stats_index")
     */
    public function index(Breadcrumbs $breadcrumbs, EntityManagerInterface $manager)
    {
        $breadcrumbs->prependRouteItem("Dashboard", "admin_home")
                    ->addRouteItem("Statistiques","admin_stats_index");
        
                    
        // produits 
        $sevenProds = $manager->createQuery('SELECT p FROM App\Entity\Product p ORDER BY p.createdAt DESC')->setMaxResults(7)->getResult();
        $allProds = $manager->createQuery('SELECT COUNT(o) as ordersTotal, SUM(o.orderTotalAmount) as sales , p.productName FROM App\Entity\Order o JOIN o.products p GROUP BY p ORDER BY sales DESC')->setMaxResults(7)->getResult();
        

        return $this->render('admin/stats/index.html.twig',[
            'prods' => $sevenProds,
            'allProds' => $allProds
        ]);
    }
}
