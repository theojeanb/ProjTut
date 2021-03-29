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
     * @ORM\OneToOne(targetEntity=Inventaire::class, inversedBy="equipement", cascade={"persist", "remove"})
     */
    private $casque;

    /**
     * @ORM\OneToOne(targetEntity=Inventaire::class, inversedBy="equipement", cascade={"persist", "remove"})
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
     * @ORM\OneToOne(targetEntity=Inventaire::class, cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCasque(): ?Armure
    {
        return $this->casque;
    }

    public function setCasque(?Armure $casque): self
    {
        $this->casque = $casque;

        return $this;
    }

    public function getPlastron(): ?Armure
    {
        return $this->plastron;
    }

    public function setPlastron(?Armure $plastron): self
    {
        $this->plastron = $plastron;

        return $this;
    }

    public function getJambieres(): ?Armure
    {
        return $this->jambieres;
    }

    public function setJambieres(?Armure $jambieres): self
    {
        $this->jambieres = $jambieres;

        return $this;
    }

    public function getBottes(): ?Armure
    {
        return $this->bottes;
    }

    public function setBottes(?Armure $bottes): self
    {
        $this->bottes = $bottes;

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
