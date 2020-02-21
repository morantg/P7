<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 * @OA\Schema()
 */
class Phone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("phone:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("phone:read")
     * @Assert\NotBlank
     * @OA\Property(type="string")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("phone:read")
     * @Assert\NotBlank
     * @OA\Property(type="string")
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("phone:read")
     * @Assert\NotBlank
     * @OA\Property(type="string")
     */
    private $couleur;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("phone:read")
     * @Assert\NotBlank
     * @OA\Property(type="string")
     */
    private $dimension;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("phone:read")
     * @Assert\NotBlank
     * @OA\Property(type="string")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("phone:read")
     * @Assert\NotBlank
     * @OA\Property(type="string")
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     * @Groups("phone:read")
     * @Assert\NotBlank
     * @OA\Property(type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("phone:read")
     */
    private $dateAjoutAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("phone:read")
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getDimension(): ?string
    {
        return $this->dimension;
    }

    public function setDimension(string $dimension): self
    {
        $this->dimension = $dimension;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
