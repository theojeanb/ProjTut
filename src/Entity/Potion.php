<?php

namespace App\Entity;

use App\Repository\PotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PotionRepository::class)
 */
class Potion
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
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Regex(pattern="/^[A-Z ]{1,}/")
     * @Assert\Length(min = 2,max = 50, minMessage = "Effet composé de 2 caractères minimum")
     */
    private $effet;

    /**
     * @Assert\PositiveOrZero(message = "La valeur ne doit pas être négative")
     * @Assert\NotBlank(message = "Saisir une valeur numérique")
     * @ORM\Column(type="integer")
     */
    private $valeur;

    /**
     * @Assert\PositiveOrZero(message = "La rareté ne doit pas être négative")
     * @Assert\NotBlank(message = "Saisir une valeur numérique")
     * @ORM\Column(type="integer")
     */
    private $rarete;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(pattern="/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/", message="Nom de fichier incorrect (extension jpeg, jpg ou png)")
     */
    private $sprite;

    /**
     * @ORM\OneToMany(targetEntity=Inventaire::class, mappedBy="potion")
     */
    private $inventaires;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    public function __construct()
    {
        $this->joueurs = new ArrayCollection();
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

    public function getEffet(): ?string
    {
        return $this->effet;
    }

    public function setEffet(string $effet): self
    {
        $this->effet = $effet;

        return $this;
    }

    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    public function setValeur(int $valeur): self
    {
        $this->valeur = $valeur;

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
            $inventaire->setPotion($this);
        }

        return $this;
    }

    public function removeInventaire(Inventaire $inventaire): self
    {
        if ($this->inventaires->removeElement($inventaire)) {
            // set the owning side to null (unless already changed)
            if ($inventaire->getPotion() === $this) {
                $inventaire->setPotion(null);
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
