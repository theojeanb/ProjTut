<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 *  * @UniqueEntity(
 * fields={"username"},
 * errorPath="username",
 * message="username already taken")
 * )
 *  * @UniqueEntity(
 * fields={"email"},
 * errorPath="email",
 * message="email already taken")
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Length(min = 2,max = 50, minMessage = "Username composé de 2 caractères minimum")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Length(min = 2,max = 50, minMessage = "Email composé de 2 caractères minimum")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

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

    /**
     * @ORM\OneToMany(targetEntity=Inventaire::class, mappedBy="joueur")
     */
    private $inventaires;

    /**
     * @ORM\OneToOne(targetEntity=Equipement::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $equipement;

    public function __construct()
    {
        $this->inventaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function setUsername(string $username): self
    {
        $this->username = $username;

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
            $inventaire->setJoueur($this);
        }

        return $this;
    }

    public function removeInventaire(Inventaire $inventaire): self
    {
        if ($this->inventaires->removeElement($inventaire)) {
            // set the owning side to null (unless already changed)
            if ($inventaire->getJoueur() === $this) {
                $inventaire->setJoueur(null);
            }
        }

        return $this;
    }

    public function getEquipement(): ?Equipement
    {
        return $this->equipement;
    }

    public function setEquipement(?Equipement $equipement): self
    {
        // unset the owning side of the relation if necessary
        if ($equipement === null && $this->equipement !== null) {
            $this->equipement->setCasque(null);
        }

        // set the owning side of the relation if necessary
        if ($equipement !== null && $equipement->getCasque() !== $this) {
            $equipement->setCasque($this);
        }

        $this->equipement = $equipement;

        return $this;
    }
}
