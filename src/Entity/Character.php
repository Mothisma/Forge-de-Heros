<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\Range(min: 1, max: 20)]
    private ?int $level = null;

    #[ORM\Column]
    #[Assert\Range(min: 8, max: 15)]
    private ?int $strength = null;

    #[ORM\Column]
    #[Assert\Range(min: 8, max: 15)]
    private ?int $dexterity = null;

    #[ORM\Column]
    #[Assert\Range(min: 8, max: 15)]
    private ?int $constitution = null;

    #[ORM\Column]
    #[Assert\Range(min: 8, max: 15)]
    private ?int $inteligence = null;

    #[ORM\Column]
    #[Assert\Range(min: 8, max: 15)]
    private ?int $wisdom = null;

    #[ORM\Column]
    #[Assert\Range(min: 8, max: 15)]
    private ?int $charisma = null;

    #[ORM\Column]
    private ?int $healthPoints = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Race $Race = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CharacterClass $Class = null;

    /**
     * @var Collection<int, Party>
     */
    #[ORM\ManyToMany(targetEntity: Party::class, mappedBy: 'Characters')]
    private Collection $parties;

    public function __construct()
    {
        $this->parties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getStrength(): ?int
    {
        return $this->strength;
    }

    public function setStrength(int $strength): static
    {
        $this->strength = $strength;

        return $this;
    }

    public function getDexterity(): ?int
    {
        return $this->dexterity;
    }

    public function setDexterity(int $dexterity): static
    {
        $this->dexterity = $dexterity;

        return $this;
    }

    public function getConstitution(): ?int
    {
        return $this->constitution;
    }

    public function setConstitution(int $constitution): static
    {
        $this->constitution = $constitution;

        return $this;
    }

    public function getInteligence(): ?int
    {
        return $this->inteligence;
    }

    public function setInteligence(int $inteligence): static
    {
        $this->inteligence = $inteligence;

        return $this;
    }

    public function getWisdom(): ?int
    {
        return $this->wisdom;
    }

    public function setWisdom(int $wisdom): static
    {
        $this->wisdom = $wisdom;

        return $this;
    }

    public function getCharisma(): ?int
    {
        return $this->charisma;
    }

    public function setCharisma(int $charisma): static
    {
        $this->charisma = $charisma;

        return $this;
    }

    public function getHealthPoints(): ?int
    {
        return $this->healthPoints;
    }

    public function setHealthPoints(int $healthPoints): static
    {
        $this->healthPoints = $healthPoints;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->Race;
    }

    public function setRace(?Race $Race): static
    {
        $this->Race = $Race;

        return $this;
    }

    public function getClass(): ?CharacterClass
    {
        return $this->Class;
    }

    public function setClass(?CharacterClass $Class): static
    {
        $this->Class = $Class;

        return $this;
    }

    /**
     * @return Collection<int, Party>
     */
    public function getParties(): Collection
    {
        return $this->parties;
    }

    public function addParty(Party $party): static
    {
        if (!$this->parties->contains($party)) {
            $this->parties->add($party);
            $party->addCharacter($this);
        }

        return $this;
    }

    public function removeParty(Party $party): static
    {
        if ($this->parties->removeElement($party)) {
            $party->removeCharacter($this);
        }

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function calculateHealthPoints(): void
    {
        $this->healthPoints = $this->Class->getHealthDice() + floor(($this->constitution - 10) / 2);
    }
}
