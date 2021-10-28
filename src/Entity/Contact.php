<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Contact
 *
 * @author Carl Fremault
 */
class Contact {

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $nom;
         
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;
           
    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    private $message;
    
    public function getNom(): ?string {
        return $this->nom;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function getMessage(): ?string {
        return $this->message;
    }

    public function setNom(?string $nom): self {
        $this->nom = $nom;
        return $this;
    }

    public function setEmail(?string $email): self {
        $this->email = $email;
        return $this;
    }

    public function setMessage(?string $message): self {
        $this->message = $message;
        return $this;
    }


}
