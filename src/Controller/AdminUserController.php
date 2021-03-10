<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Services\Pagination\PaginationService;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/users/{page<\d+>?1} ", name="admin_user_index")
     */
    public function index($page, PaginationService $pagination,Breadcrumbs $breadcrumbs)
    {
        $pagination->setEntityClass(User::class)
                   ->setPage($page)
                   ->setLimit(40);

        $breadcrumbs->prependRouteItem("Dashboard", "admin_home")
                    ->addRouteItem("Utilisateurs","admin_user_index");

        return $this->render('admin/user/index.html.twig', [   
            'pagination' => $pagination
        ]);
    }

    /**
     * Suppression d'un utilisateur
     *
     * @Route("admin/user/{id}/delete", name="admin_user_delete")
     * 
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(User $user,EntityManagerInterface $manager)
    {
        if (count($user->getOrders()) > 0) {
            $this->addFlash(
                'warning',
                "Vous ne pouvez pas supprimer cet utilisateur car il a des commandes"
            );
        } else {
            $manager->remove($user);
            $manager->flush();

            return $this->redirectToRoute("admin_user_index");
        }
    }

    /**
     * Affichage du détail d'un utilisateur
     * 
     * @Route("admin/user/details/{id}", name="admin_user_show")
     *
     * @param User $user
     * @return void
     */
    public function show(User $user,EntityManagerInterface $manager, Breadcrumbs $breadcrumbs,PaginatorInterface $pagination, OrderRepository $repo,Request $request)
    {

        // Nombre total de commandes sur le site
        $total = $manager->createQuery(
            'SELECT SUM(o.orderTotalAmount) as total
             FROM App\Entity\User u
             JOIN u.orders o
             WHERE u.id = :id_util')
             ->setParameter('id_util',$user->getId())
             ->getSingleScalarResult();

        $orders = $repo->findBy(['users' => $user]);
        $page = $pagination->paginate($orders,$request->query->getInt('page',1),4);

        $breadcrumbs->prependRouteItem("Dashboard", "admin_home")
                    ->addRouteItem("Utilisateurs","admin_user_index")
                    ->addRouteItem("Détail","admin_user_show",['id'=> $user->getId()]);
                    
        return $this->render('admin/user/show.html.twig',[
            'user' => $user,
            'total' => $total,
            'pagination' => $page
        ]);
    }    
}
