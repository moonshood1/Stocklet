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
                    'expiration_date' => new \DateTime('+7 days'),
                    'username' => $userFullName,
                    'token' => $token
                ]);

        $this->mailer->send($email); 
    }
   
}
