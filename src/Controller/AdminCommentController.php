<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Services\Pagination\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comment/{page<\d+>?1} ", name="admin_comment_index")
     */
    public function index(CommentRepository $repo,$page, PaginationService $pagination)
    {
        $pagination->setEntityClass(Comment::class)
                   ->setLimit(5)
                   ->setPage($page);

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
