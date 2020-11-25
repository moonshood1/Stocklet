<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Services\Pagination\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminOrderController extends AbstractController
{
    /**
     * @Route("/admin/order/{page<\d+>?1} ", name="admin_order_index")
     */
    public function index(OrderRepository $repo, $page, PaginationService $pagination)
    {
        $pagination->setPage($page)
                   ->setEntityClass(Order::class);

        return $this->render('admin/order/index.html.twig', [
            'pagination'=> $pagination
        ]);
    }

    /**
     * Suppression d'une commande
     * 
     * @Route("admin/order/{id}/delete", name="admin_order_delete")
     *
     * @param Order $order
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(Order $order ,EntityManagerInterface $manager)
    {
        if (count($order->getProducts()) > 0) {
            $this->addFlash(
                'warning',
                "Vous ne pouvez pas supprimer cette commande car elle a deja été validée"
            );
        } else {
            $manager->remove($order);
            $manager->flush();
        }

        return $this->redirectToRoute('admin_products_index');
    }   
    
    /**
     * Affichage d'une commande
     * 
     * @Route("admin/order/details/{id}", name="admin_order_show")
     * 
     * @param Order $order
     * @return void
     */
    public function show(Order $order,EntityManagerInterface $manager)
    {
        // Nombre total de commandes sur le site
        $total = $manager->createQuery(
            'SELECT SUM(o.orderTotalAmount) as total
             FROM App\Entity\User u
             JOIN u.orders o
             WHERE u.id = :id_util')
             ->setParameter('id_util',$order->getUsers()->getId())
             ->getSingleScalarResult();


        return $this->render('admin/order/show.html.twig',[
            'order' => $order,
            'total'=> $total
        ]);
    }
}
