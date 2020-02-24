<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @OA\Schema()
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("client:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("client:read")
     * @Assert\NotBlank
     * @OA\Property(type="string")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("client:read")
     * @Assert\NotBlank
     * @OA\Property(type="string")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("client:read")
     * @Assert\NotBlank
     * @OA\Property(type="string")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("client:read")
     * @Assert\NotBlank
     * @OA\Property(type="string")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("client:read")
     * @Assert\NotBlank
     * @OA\Property(type="string")
     */
    private $telephone;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("client:read")
     */
    private $dateAjoutAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="clients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("client:read")
     */
    private $dateModifAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getDateAjoutAt(): ?\DateTimeInterface
    {
        return $this->dateAjoutAt;
    }

    public function setDateAjoutAt(\DateTimeInterface $dateAjoutAt): self
    {
        $this->dateAjoutAt = $dateAjoutAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDateModifAt(): ?\DateTimeInterface
    {
        return $this->dateModifAt;
    }

    public function setDateModifAt(?\DateTimeInterface $dateModifAt): self
    {
        $this->dateModifAt = $dateModifAt;

        return $this;
    }
}
