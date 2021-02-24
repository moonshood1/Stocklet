<?php


namespace App\Services\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerService 
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    
    public function sendEmail($userEmail, $token, $userFullName)
    {
        $email = (new TemplatedEmail())
            ->from('payqin@stocklet.ci')
            ->to($userEmail)
            ->subject('Validation de l\'inscription sur STOCKLET')
            ->htmlTemplate("partials/emails/signup.html.twig")
            ->context([
                    'username' => $userFullName,
                    'token' => $token
                ]);

        $this->mailer->send($email); 
    }

    public function sendEmailAfterOauth($userEmail,$userFullName,$password)
    {
        $email = (new TemplatedEmail())
            ->from('payqin@stocklet.ci')
            ->to($userEmail)
            ->subject("Confirmation de l'inscription sur STOCKLET")
            ->htmlTemplate("partials/emails/confirm.html.twig")
            ->context([
                'username' => $userFullName,
                'password' => $password
            ]);
        $this->mailer->send($email);
    }

    public function sendOrderDetails($userEmail,$invoices,$invoiceNumber,$userFirstName, $userLastName)
    {
        $email = (new TemplatedEmail())
                ->from('payqin@stocklet.ci')
                ->to($userEmail)
                ->subject('Details de la commande:'.$invoiceNumber)
                ->htmlTemplate("partials/emails/detailsOrder.html.twig")
                ->context([
                    'firstName'=> $userFirstName,
                    'lastName' => $userLastName,
                    'invoices' => $invoices,
                    'invoice' => $invoiceNumber
                ]);

        $this->mailer->send($email);        
    }


    public function contactPayQin($payqin_email,$user_email,$user_subject,$message, $username)
    {
        $email = (new TemplatedEmail())
                ->from($user_email)
                ->to($payqin_email)
                ->subject($user_subject)
                ->htmlTemplate("partials/emails/contactPayQin.html.twig")
                ->context([
                    'username' => $username,
                    'message' => $message]);
        
        $this->mailer->send($email);
    }

    public function sendTest($user_email)
    {
        $email = (new TemplatedEmail())
                ->from('hello@stocklet.ci')
                ->to($user_email)
                ->subject("Bonjour")
                ->htmlTemplate("partials/emails/test.html.twig");

        $this->mailer->send($email);
    }
   
}
