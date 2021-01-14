<?php

namespace App\Entity;

use App\Repository\ArmeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=ArmeRepository::class)
 */
class Arme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Regex(pattern="/^[A-Za-z ]{1,}/")
     * @Assert\Length(min = 2,max = 50, minMessage = "Nom composé de 2 caractères minimum")
     */
    private $nom;

    /**
     * @Assert\PositiveOrZero(message = "Les dégâts ne doivent pas être négatifs")
     * @Assert\NotBlank(message = "Saisir une valeur numérique")
     * @ORM\Column(type="integer")
     */
    private $degats;

    /**
     * @Assert\PositiveOrZero(message = "La rareté ne doit pas être négative")
     * @Assert\NotBlank(message = "Saisir une valeur numérique")
     * @ORM\Column(type="integer")
     */
    private $rarete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sprite;

    /**
     * @ORM\OneToMany(targetEntity=Ennemi::class, mappedBy="arme")
     */
    private $ennemis;

    /**
     * @ORM\OneToMany(targetEntity=Inventaire::class, mappedBy="arme")
     */
    private $inventaires;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    public function __construct()
    {
        $this->Joueur = new ArrayCollection();
        $this->joueurs = new ArrayCollection();
        $this->ennemis = new ArrayCollection();
        $this->inventaires = new ArrayCollection();
    }

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

    public function getDegats(): ?int
    {
        return $this->degats;
    }

    public function setDegats(int $degats): self
    {
        $this->degats = $degats;

        return $this;
    }

    public function getRarete(): ?int
    {
        return $this->rarete;
    }

    public function setRarete(int $rarete): self
    {
        $this->rarete = $rarete;

        return $this;
    }

    public function getSprite(): ?string
    {
        return $this->sprite;
    }

    public function setSprite(?string $sprite): self
    {
        $this->sprite = $sprite;

        return $this;
    }

    /**
     * @return Collection|Ennemi[]
     */
    public function getEnnemis(): Collection
    {
        return $this->ennemis;
    }

    public function addEnnemi(Ennemi $ennemi): self
    {
        if (!$this->ennemis->contains($ennemi)) {
            $this->ennemis[] = $ennemi;
            $ennemi->setArme($this);
        }

        return $this;
    }

    public function removeEnnemi(Ennemi $ennemi): self
    {
        if ($this->ennemis->removeElement($ennemi)) {
            // set the owning side to null (unless already changed)
            if ($ennemi->getArme() === $this) {
                $ennemi->setArme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Inventaire[]
     */
    public function getInventaires(): Collection
    {
        return $this->inventaires;
    }

    public function addInventaire(Inventaire $inventaire): self
    {
        if (!$this->inventaires->contains($inventaire)) {
            $this->inventaires[] = $inventaire;
            $inventaire->setArme($this);
        }

        return $this;
    }

    public function removeInventaire(Inventaire $inventaire): self
    {
        if ($this->inventaires->removeElement($inventaire)) {
            // set the owning side to null (unless already changed)
            if ($inventaire->getArme() === $this) {
                $inventaire->setArme(null);
            }
        }

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
