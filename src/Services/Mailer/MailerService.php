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

            // Chemin vers le template du mail
            ->htmlTemplate("partials/emails/signup.html.twig")

                // les varialbles qu'on passe au template
                ->context([
                    'username' => $userFullName,
                    'token' => $token
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
   
}
