<?php

namespace App\Controller;

use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\PasswordUpdateType;
use App\Repository\CommentRepository;
use App\Repository\OrderRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class AdminAccountController extends AbstractController
{

    /**
     * @Route("/admin/login", name="admin_account_login")
     *
     * @param AuthenticationUtils $utils
     * @return void
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('admin/account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username,
        ]);
    }

    /**
     * @Route("/admin/logout", name="admin_account_logout")
     *
     * @return void
     */
    public function logout()
    {

    }

    /**
     * Permet de modifier son profil utilisateur
     * 
     * @Route("/admin/account/profile", name="admin_account_profile")
     * 
     * @return Response
     */
    public function profile(Request $request, EntityManagerInterface $manager,Breadcrumbs $breadcrumbs)
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

         return $this->redirectToRoute("admin_account");

        }

        $breadcrumbs->prependRouteItem("Dashboard","admin_home")
                    ->addRouteItem("Mon Compte","admin_account")
                    ->addRouteItem("Modification du profil","admin_account_profile");

        return $this->render('admin/account/profile.html.twig',[
            'form' => $form->createView()
        ]);
    } 
    /**
     * Permet de modifier le mot de passe
     * 
     * @Route("admin/account/password-update", name="admin_account_password")
     *
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager, Breadcrumbs $breadcrumbs)
    {
        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class,$passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())) {
               $form->get('oldPassword')->addError(new FormError("Le mot de passe actuel n'est pas correct"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user,$newPassword);

                $user->setPassword($hash);

                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute("admin_home");
            }
        }

                $breadcrumbs->prependRouteItem("Dashboard","admin_home")
                    ->addRouteItem("Mon Compte","admin_account")
                    ->addRouteItem("Modification du mot de passe","admin_account_password");

        return $this->render('admin/account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }       
    /**
     * @Route("/admin/account", name="admin_account")
     */
    public function myAccount(Breadcrumbs $breadcrumbs, PaginatorInterface $pagination, OrderRepository $repo,Request $request,CommentRepository $commentRepo)
    {
        $user = $this->getUser();

        $orders = $repo->findBy(['users' => $user]);
        $orderPage = $pagination->paginate($orders,$request->query->getInt('page',1),4);


        $comments = $commentRepo->findBy(['author'  => $user]);
        $commentPage = $pagination->paginate($comments,$request->query->getInt('page',1),4);

        $breadcrumbs->prependRouteItem("Dashboard","admin_home")
                    ->addRouteItem("Mon Compte","admin_account");

        return $this->render('admin/account/account.html.twig', [
            'user' => $user,
            'comment_pagination' => $commentPage,
            'order_pagination' => $orderPage
        ]);
    }
}
