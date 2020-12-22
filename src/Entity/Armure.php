<?php

namespace App\Entity;

use App\Repository\ArmureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArmureRepository::class)
 */
class Armure
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
     * @Assert\PositiveOrZero(message = "La défense ne doit pas être négative")
     * @Assert\NotBlank(message = "Saisir une valeur numérique")
     * @ORM\Column(type="integer")
     */
    private $defense;

    /**
     * @Assert\PositiveOrZero(message = "La rareté ne doit pas être négative")
     * @Assert\NotBlank(message = "Saisir une valeur numérique")
     * @ORM\Column(type="integer")
     */
    private $rarete;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="armures")
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="armures")
     */
    private $joueurs;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(pattern="/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/", message="Nom de fichier incorrect (extension jpeg, jpg ou png)")
     */
    private $sprite;

    /**
     * @ORM\OneToMany(targetEntity=Ennemi::class, mappedBy="armure")
     */
    private $ennemis;

    /**
     * @ORM\OneToMany(targetEntity=Inventaire::class, mappedBy="armure")
     */
    private $inventaires;

    public function __construct()
    {
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

    public function getDefense(): ?int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): self
    {
        $this->defense = $defense;

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

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(User $joueur): self
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs[] = $joueur;
        }

        return $this;
    }

    public function removeJoueur(User $joueur): self
    {
        $this->joueurs->removeElement($joueur);

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
            $ennemi->setArmure($this);
        }

        return $this;
    }

    public function removeEnnemi(Ennemi $ennemi): self
    {
        if ($this->ennemis->removeElement($ennemi)) {
            // set the owning side to null (unless already changed)
            if ($ennemi->getArmure() === $this) {
                $ennemi->setArmure(null);
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
            $inventaire->setArmure($this);
        }

        return $this;
    }

    public function removeInventaire(Inventaire $inventaire): self
    {
        if ($this->inventaires->removeElement($inventaire)) {
            // set the owning side to null (unless already changed)
            if ($inventaire->getArmure() === $this) {
                $inventaire->setArmure(null);
            }
        }

        return $this;
    }
}
