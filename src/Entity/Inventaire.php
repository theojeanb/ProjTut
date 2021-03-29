<?php

namespace App\Entity;

use App\Repository\InventaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventaireRepository::class)
 */
class Inventaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="inventaires")
     */
    private $joueur;

    /**
     * @ORM\ManyToOne(targetEntity=Arme::class, inversedBy="inventaires")
     */
    private $arme;

    /**
     * @ORM\ManyToOne(targetEntity=Armure::class, inversedBy="inventaires")
     */
    private $armure;

    /**
     * @ORM\ManyToOne(targetEntity=Potion::class, inversedBy="inventaires")
     */
    private $potion;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $x;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $y;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJoueur(): ?User
    {
        return $this->joueur;
    }

    public function setJoueur(?User $joueur): self
    {
        $this->joueur = $joueur;

        return $this;
    }

    public function getArme(): ?Arme
    {
        return $this->arme;
    }

    public function setArme(?Arme $arme): self
    {
        $this->arme = $arme;

        return $this;
    }

    public function getArmure(): ?Armure
    {
        return $this->armure;
    }

    public function setArmure(?Armure $armure): self
    {
        $this->armure = $armure;

        return $this;
    }

    public function getPotion(): ?Potion
    {
        return $this->potion;
    }

    public function setPotion(?Potion $potion): self
    {
        $this->potion = $potion;

        return $this;
    }

    public function getX(): ?int
    {
        return $this->x;
    }

    public function setX(?int $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(?int $y): self
    {
        $this->y = $y;

        return $this;
    }
}
