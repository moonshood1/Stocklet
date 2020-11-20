<?php

namespace App\Controller;

use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    public function profile(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

         return $this->redirectToRoute("admin_account");

        }
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
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager)
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

        return $this->render('admin/account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }       
    /**
     * @Route("/admin/account", name="admin_account")
     */
    public function myAccount()
    {
        $user = $this->getUser();
        return $this->render('admin/account/account.html.twig', [
            'user' => $user
        ]);
    }
}
