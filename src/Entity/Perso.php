<?php

namespace App\Entity;

use App\Repository\PersoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersoRepository::class)
 */
class Perso
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="perso", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $attaque;

    /**
     * @ORM\Column(type="integer")
     */
    private $defense;

    /**
     * @ORM\Column(type="integer")
     */
    private $argent;

    /**
     * @ORM\Column(type="integer")
     */
    private $pvMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveau;

    /**
     * @ORM\Column(type="integer")
     */
    private $experience;

    /**
     * @ORM\Column(type="integer")
     */
    private $pv;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAttaque(): ?int
    {
        return $this->attaque;
    }

    public function setAttaque(int $attaque): self
    {
        $this->attaque = $attaque;

        return $this;
    }

    public function getDefense(): ?int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): self
    {
        $this->defense = $defense;

        return $this;
    }

    public function getArgent(): ?int
    {
        return $this->argent;
    }

    public function setArgent(int $argent): self
    {
        $this->argent = $argent;

        return $this;
    }

    public function getPvMax(): ?int
    {
        return $this->pvMax;
    }

    public function setPvMax(int $pvMax): self
    {
        $this->pvMax = $pvMax;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getPv(): ?int
    {
        return $this->pv;
    }

    public function setPv(int $pv): self
    {
        $this->pv = $pv;

        return $this;
    }
}
