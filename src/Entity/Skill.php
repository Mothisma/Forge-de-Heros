<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\Choice(['STR','DEX','CON','INT','WIS','CHA'])]
    private ?string $ability = null;

    /**
     * @var Collection<int, CharacterClass>
     */
    #[ORM\ManyToMany(targetEntity: CharacterClass::class, mappedBy: 'Skills')]
    private Collection $Classes;

    public function __construct()
    {
        $this->Classes = new ArrayCollection();
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

    public function getAbility(): ?string
    {
        return $this->ability;
    }

    public function setAbility(string $ability): static
    {
        $this->ability = $ability;

        return $this;
    }

    /**
     * @return Collection<int, CharacterClass>
     */
    public function getClasses(): Collection
    {
        return $this->Classes;
    }

    public function addClass(CharacterClass $class): static
    {
        if (!$this->Classes->contains($class)) {
            $this->Classes->add($class);
            $class->addSkill($this);
        }

        return $this;
    }

    public function removeClass(CharacterClass $class): static
    {
        if ($this->Classes->removeElement($class)) {
            $class->removeSkill($this);
        }

        return $this;
    }
}
