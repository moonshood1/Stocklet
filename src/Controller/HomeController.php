<?php

namespace App\Controller;

use DateTime;
use App\Entity\Comment;
use App\Entity\CommentDisLike;
use App\Form\CommentType;
use App\Entity\CommentLike;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentLikeRepository;
use App\Repository\CommentDisLikeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $product,Request $request,EntityManagerInterface $manager,CommentRepository $commentRepo):Response
    {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        /* if ($this->getUser()->getRegisteredAt()) {
            $userDate = date_format($this->getUser()->getRegisteredAt(),'Y');
            $now = date_format(new DateTime('now'),'Y');
            $diff = $now - $userDate;
        } else {
            $diff = 0;
        } */

        if ($form->isSubmitted()) {
            $comment->setProduct($product->findOneBy(array('productAvailable'=> 1)))
                    ->setAuthor($this->getUser())
                    ->setCreatedAt(new DateTime('now'));

               /*  if ($request->isXmlHttpRequest()) {
                    $manager->persist($comment);
                    $manager->flush();
                    return new JsonResponse('ok',200,[],true);
                } */

                $manager->persist($comment);
                $manager->flush();

                return $this->redirectToRoute("home");
        }

        return $this->render('home/index.html.twig', [
            'product'=> $product->findOneBy(array('productAvailable'=> 1)),
            'comment' => $comment,
            'form' => $form->createView(),
            'comments' => $commentRepo->findAll(),
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/demain", name="product_date")
     *
     * @return Response
     */
    public function tomorrow(ProductRepository $product):Response
    {
        $available = $product->findOneBy(array('productAvailable'=> 1));
        $thedate = $available->getEndDate();
        $formated = $thedate->format('Y-m-d H:i:s');

        $date = new DateTime($formated);

        return $this->json([
            '200'=>200,
            'message'=> 'date bien envoyée',
            'demain' => $date
        ],200);
    } 
       
    /**
     * @Route("/switch", name="switch_product")
     *
     * @param ProductRepository $repo
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function switchAvailability(ProductRepository $repo, EntityManagerInterface $manager):Response
    {         
            // Obtenir le produit affiché et mettre son available a 0
            $current = $repo->findOneBy(array('productAvailable'=> 1));

            // Recuperation de tous les éléments du tableau
                $all = $repo->findAll();
            
            // Si le précédent est dispo alors on le change puis on set la dispo du next a true (theorie 1)
            // Pour chaque produits dans le tableau complet , si un produit a un available a true , on le set a false (theorie 2)
                if ($current->getProductAvailable() === true) {

                    $index = array_search($current, $all);
            // Si on trouve current avec l'index alors $prev est $current-1
                    if($index !== false && $index > 0 ) $prev = $all[$index-1];

            // Si on trouve current et qu'il n'est pas le dernier element du tableau alors $next est $current+1
                    if($index !== false && $index < count($all)-1) $next = $all[$index+1];

                    $current->setProductAvailable(false);
            // On trouve le produit qui le suit puis on le set a true
                    $next->setProductAvailable(true);
                    $manager->persist($current);
                    $manager->persist($next);
                    $manager->flush();
                }

                dump($current);
            
        // Enfin , dans le json, on renvoie le next product setté a true    
                    return $this->redirectToRoute("home");
   }
   
   /**
    * Fonction de like
    * @Route("/comment/{id}/like", name="comment_like")
    * @param Comment $comment
    * @param EntityManagerInterface $manager
    * @param CommentLikeRepository $likerepo
    * @return Response
    */
   public function like(Comment $comment, EntityManagerInterface $manager,CommentLikeRepository $likerepo):Response
   {
       $user = $this->getUser();

       // Si l'utilisateur n'est pas connecté , il ne peut pas liker
       if (!$user) return  $this->json(['code'=> 403, 'message'=> 'connexion requise'],403);

       // Si il est connecté et qu'il a deja liké , on supprime le like
       if ($comment->isLikedByUser($user)) {
           $like = $likerepo->findOneBy([
               'comment' => $comment,
               'user' => $user
           ]);
           $manager->remove($like);
           $manager->flush();

           return $this->json([
               'code' => 200,
               'message'=> 'like bien supprimé',
               'likes' => $likerepo->count(['comment'=> $comment])
           ],200);
       }

       // si il est connecté et qu'il n'a pas liké , on cree un nouveau like
       $like = new CommentLike();
       $like->setComment($comment)
            ->setUser($user);
       $manager->persist($like);
       $manager->flush();
       
       return $this->json([
           'code' => 200,
           'message' => 'like bien ajouté',
           'likes' => $likerepo->count(['comment'=> $comment])
       ], 200);
   }

   /**
    * Fonction de Dislike
    * @Route("/comment/{id}/dislike", name="comment_dislike")
    * @param Comment $comment
    * @param EntityManagerInterface $manager
    * @param CommentDisLikeRepository $dislikerepo
    * @return Response
    */
   public function dislike(Comment $comment, EntityManagerInterface $manager,CommentDisLikeRepository $dislikerepo):Response
   {
       $user = $this->getUser();

       // Si l'utilisateur n'est pas connecté , il ne peut pas disliker
       if (!$user) return  $this->json(['code'=> 403, 'message'=> 'connexion requise'],403);

       // Si il est connecté et qu'il a deja disliké , on supprime le dislike
       if ($comment->isDislikedByUser($user)) {
           $dislike = $dislikerepo->findOneBy([
               'comment' => $comment,
               'user' => $user
           ]);
           $manager->remove($dislike);
           $manager->flush();

           return $this->json([
               'code' => 200,
               'message'=> 'dislike bien supprimé',
               'dislikes' => $dislikerepo->count(['comment'=> $comment])
           ],200);
       }

       // si il est connecté et qu'il n'a pas disliké , on cree un nouveau dislike
       $dislike = new CommentDisLike();
       $dislike->setComment($comment)
               ->setUser($user);
       $manager->persist($dislike);
       $manager->flush();
       
       return $this->json([
           'code' => 200,
           'message' => 'dislike bien ajouté',
           'dislikes' => $dislikerepo->count(['comment'=> $comment])
       ], 200);       
   }
}
