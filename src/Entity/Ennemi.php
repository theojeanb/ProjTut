<?php

namespace App\Entity;

use App\Repository\EnnemiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EnnemiRepository::class)
 */
class Ennemi
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
     * @Assert\PositiveOrZero(message = "Les PV ne doivent pas être négatifs")
     * @Assert\NotBlank(message = "Saisir une valeur numérique")
     * @ORM\Column(type="integer")
     */
    private $pv;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Regex(pattern="/[A-Za-z0-9]{2,}.(jpeg|jpg|png)/", message="Nom de fichier incorrect (extension jpeg, jpg ou png)")
     */
    private $sprite;

    /**
     * @ORM\ManyToOne(targetEntity=Arme::class, inversedBy="ennemis")
     */
    private $arme;

    /**
     * @ORM\ManyToOne(targetEntity=Armure::class, inversedBy="ennemis")
     */
    private $armure;

    /**
     * @ORM\ManyToOne(targetEntity=Potion::class, inversedBy="ennemis")
     */
    private $potion;

    public function __construct()
    {
        $this->armures = new ArrayCollection();
        $this->armes = new ArrayCollection();
        $this->potions = new ArrayCollection();
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

    public function getPv(): ?int
    {
        return $this->pv;
    }

    public function setPv(int $pv): self
    {
        $this->pv = $pv;

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
}
