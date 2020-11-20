<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\Pagination\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/users/{page<\d+>?1} ", name="admin_user_index")
     */
    public function index($page, PaginationService $pagination)
    {
        $pagination->setEntityClass(User::class)
                   ->setPage($page);
                   
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
    public function show(User $user)
    {
        return $this->render('admin/user/show.html.twig',[
            'user' => $user
        ]);
    }    
}
