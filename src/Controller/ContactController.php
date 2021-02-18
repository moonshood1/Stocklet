<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Services\Mailer\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact_index")
     */
    public function contact(Request $request,MailerService $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        $payqin_email = "hello@payqin.ci";
        $user_email = $request->request->get('contact')['user_email'];
        $user_subject = $request->request->get('contact')['user_subject'];
        $message = $request->request->get('contact')['content'];
        $username =  $request->request->get('contact')['user_userName'];

        if ($form->isSubmitted()) {
            $mailer->contactPayQin(
                $payqin_email,
                $user_email,
                $user_subject,
                $message,
                $username
            );

            $this->addFlash("success","Votre email a bien été envoyé !");

            return $this->redirectToRoute("contact_index");
        }

        return $this->render('contact/index.html.twig',[
            'user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contact/about", name="about_index")
     */
    public function about()
    {
        return $this->render('contact/about.html.twig',[
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/contact/offices", name="offices_index")
     */
    public function offices()
    {
        return $this->render('contact/offices.html.twig',[
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/contact/garanties", name="garanties_index")
     */
    public function garanties()
    {
        return $this->render('contact/garanties.html.twig',[
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/contact/livraisons", name="livraisons_index")
     */
    public function livraisons()
    {
        return $this->render('contact/livraisons.html.twig',[
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/contact/retours", name="retours_index")
     */
    public function retours()
    {
        return $this->render('contact/retours.html.twig',[
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/contact/faq", name="faq_index")
     */
    public function faq()
    {
        return $this->render('contact/faq.html.twig',[
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/contact/terms", name="terms_index")
     */
    public function terms()
    {
        return $this->render('contact/terms.html.twig',[
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/contact/privacy", name="privacy_index")
     */    
    public function privacy()
    {
        return $this->render('contact/privacy.html.twig',[
            'user' => $this->getUser()
        ]);
    }


}
