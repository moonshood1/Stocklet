<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Services\Pagination\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comment/{page<\d+>?1} ", name="admin_comment_index")
     */
    public function index($page, PaginationService $pagination,Breadcrumbs $breadcrumbs)
    {
        $pagination->setEntityClass(Comment::class)
                   ->setLimit(7)
                   ->setPage($page);

            $breadcrumbs->prependRouteItem("Dashboard","admin_home")
                    ->addRouteItem("Commentaires","admin_comment_index");           

        return $this->render('admin/comment/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
    /**
     * Suppression d'un commentaire
     * 
     * @Route("admin/comment/{id}/delete", name="admin_comment_delete")
     *
     * @param Comment $comment
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(Comment $comment ,EntityManagerInterface $manager)
    {
            $manager->remove($comment);
            $manager->flush();
        
        return $this->redirectToRoute('admin_comment_index');

    }     
}
