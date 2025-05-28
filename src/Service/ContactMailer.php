<?php

namespace App\Service;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

//Final = pas d'héritage, reste dans la class et on créé ici un service car c'est pour imaginer qu'on utilise différents formulaires sur tout le site 
final class ContactMailer
{
    public function __construct(
        private MailerInterface $mailer,
        private string $toEmail //injecté depuis les services.yaml (.env)
    ) {}

    public function sendContactMessage(Contact $contact): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($contact->getEmail()))
            ->to($this->toEmail)
            ->replyTo($contact->getEmail())
            ->subject($contact->getSubject())
            ->htmlTemplate('email/contact.html.twig')
            ->context([
                'firstName' => $contact->getFirstName(),
                'lastName' => $contact->getLastName(),
                'senderEmail' => $contact->getEmail(),
                'subject' => $contact->getSubject(),
                'message' => $contact->getMessage(),
                'phone' => $contact->getPhone(),
            ]);

        $this->mailer->send($email);
    }
}
