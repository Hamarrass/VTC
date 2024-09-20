<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Client::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $client;

    #[ORM\ManyToOne(targetEntity: Conducteur::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $conducteur;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    private $pickupLocation;

    #[ORM\Column(type: 'string', length: 255)]
    private $dropoffLocation;

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getConducteur(): ?Conducteur
    {
        return $this->conducteur;
    }

    public function setConducteur(Conducteur $conducteur): self
    {
        $this->conducteur = $conducteur;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPickupLocation(): ?string
    {
        return $this->pickupLocation;
    }

    public function setPickupLocation(string $pickupLocation): self
    {
        $this->pickupLocation = $pickupLocation;

        return $this;
    }

    public function getDropoffLocation(): ?string
    {
        return $this->dropoffLocation;
    }

    public function setDropoffLocation(string $dropoffLocation): self
    {
        $this->dropoffLocation = $dropoffLocation;

        return $this;
    }
}
