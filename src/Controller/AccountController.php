<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use App\Repository\PaymentRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     *
     * @param AuthenticationUtils $utils
     * @return void
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username,
        ]);
    }

    /**
     * @Route("oauth/google/connect", name="oauth_google_connexion")
     * @param ClientRegistry $clientRegistry
     * @return Response
     */
    public function connectToGoogle(ClientRegistry $clientRegistry)
    {
        return $clientRegistry->getClient('google')
                ->redirect(['profile'],['email']);
    }

    /**
     * @Route("oauth/facebook/connect", name="oauth_facebook_connexion")
     * @param ClientRegistry $clientRegistry
     * @return Response
     */
    public function connectToFacebook(ClientRegistry $clientRegistry)
    {
        return $clientRegistry->getClient('facebook')
            ->redirect(['public_profile'],['email']);
    }

    /**
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    public function logout()
    {

    }

    /**
     * @Route("/register", name="account_register")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("account_login");
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * 
     * 
     * @IsGranted("ROLE_USER")
     * @Route("/account/profile",name="account_profile")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function profile(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("account_index");
        }

        return $this->render('account/profile.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }
    /**
     * @IsGranted("ROLE_USER")
     * @Route("account/password-update", name="account_password")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function updatePassword(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();
        $form= $this->createForm(PasswordUpdateType::class,$passwordUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!password_verify($passwordUpdate->getOldPassword(),$user->getPassword())) {
                $form->get('oldPassword')->addError(new FormError("Le mot de passe entré n'est pas correct"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user,$newPassword);

                $user->setPassword($hash);

                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute("account_index");
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser()
        ]);

    }

    /**
     * Fonction de toutes les commandes
     * @Route("/account/orders", name="account_orders")
     * @param PaymentRepository $repo
     * @return void
     */
    public function orders(PaymentRepository $repo)
    {
        return $this->render('account/orders.html.twig',[
            'payments' => $repo->findAll(),
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/account/payment", name="account_payment_index")
     */
    public function payment()
    {
        $user = $this->getUser();
        return $this->render('account/payment.html.twig',[
            'user'=> $user
        ]);

    }

    /**
     * @Route("/account", name="account_index")
     */
    public function myAccount()
    {
        return $this->render('account/account.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
