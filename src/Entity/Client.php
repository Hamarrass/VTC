<?php
// src/Entity/Client.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
class Client implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    // UserInterface methods

    /**
     * Returns the identifier for this user (e.g. email).
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * This method was used in older versions of Symfony but is deprecated.
     * You can keep it for backward compatibility, but it's no longer necessary.
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
        // Si tu stockes des données sensibles temporaires sur l'utilisateur, efface-les ici
    }
}
