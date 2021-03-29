<?php

namespace App\Entity;

use App\Repository\EquipementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipementRepository::class)
 */
class Equipement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Inventaire::class, cascade={"persist", "remove"})
     */
    private $arme;

    /**
     * @ORM\OneToOne(targetEntity=Inventaire::class, cascade={"persist", "remove"})
     */
    private $casque;

    /**
     * @ORM\OneToOne(targetEntity=Inventaire::class, cascade={"persist", "remove"})
     */
    private $plastron;

    /**
     * @ORM\OneToOne(targetEntity=Inventaire::class, cascade={"persist", "remove"})
     */
    private $jambieres;

    /**
     * @ORM\OneToOne(targetEntity=Inventaire::class, cascade={"persist", "remove"})
     */
    private $bottes;

    /**
     * @ORM\OneToOne(targetEntity=Inventaire::class, cascade={"persist", "remove"})
     */
    private $potion;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="equipement", cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArme(): ?Inventaire
    {
        return $this->arme;
    }

    public function setArme(?Inventaire $arme): self
    {
        $this->arme = $arme;

        return $this;
    }

    public function getCasque(): ?Inventaire
    {
        return $this->casque;
    }

    public function setCasque(?Inventaire $casque): self
    {
        $this->casque = $casque;

        return $this;
    }

    public function getPlastron(): ?Inventaire
    {
        return $this->plastron;
    }

    public function setPlastron(?Inventaire $plastron): self
    {
        $this->plastron = $plastron;

        return $this;
    }

    public function getJambieres(): ?Inventaire
    {
        return $this->jambieres;
    }

    public function setJambieres(?Inventaire $jambieres): self
    {
        $this->jambieres = $jambieres;

        return $this;
    }

    public function getBottes(): ?Inventaire
    {
        return $this->bottes;
    }

    public function setBottes(?Inventaire $bottes): self
    {
        $this->bottes = $bottes;

        return $this;
    }

    public function getPotion(): ?Inventaire
    {
        return $this->potion;
    }

    public function setPotion(?Inventaire $potion): self
    {
        $this->potion = $potion;

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
}
