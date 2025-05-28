<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    #[Assert\NotBlank(message: 'Le prénom est obligatoire')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le prénom doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Le prénom ne doit pas dépasser {{ limit }} caractères'
    )]
    private string $firstName;

    #[Assert\NotBlank(message: 'Le nom est obligatoire')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le nom doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères'
    )]
    private string $lastName;

    #[Assert\NotBlank(message: 'L\'adresse email est obligatoire')]
    #[Assert\Email(message: 'L\'adresse email n\'est pas valide')]
    private string $email;

    #[Assert\NotBlank(message: 'L\'objet est obligatoire')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'L\'objet doit contenir au moins {{ limit }} caractères',
        maxMessage: 'L\'objet ne doit pas dépasser {{ limit }} caractères'
    )]
    private string $subject;

    #[Assert\NotBlank(message: 'Le message est obligatoire')]
    private string $message;

    #[Assert\NotBlank(message: 'Le téléphone est obligatoire')]
    #[Assert\Regex(
        pattern: '/^\+?[0-9\s\-()]{7,20}$/',
        message: 'Le numéro de téléphone est invalide'
    )]
    private string $phone;

    // Getters et Setters

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = htmlspecialchars(strip_tags($firstName));
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = filter_var($email, \FILTER_SANITIZE_EMAIL);
        return $this;
        /**
         * Si l'utilisateur rentre dans le champs input robert<script>@gmail.com
         * La sortie va être robert@gmail.com
         */
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }
}
