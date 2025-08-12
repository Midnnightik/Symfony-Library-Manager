<?php
// src/Entity/Category.php
namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\UniqueConstraint(columns: ['name'])]
#[ORM\UniqueConstraint(columns: ['slug'])]
class Category
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank, Assert\Length(max: 120)]
    #[ORM\Column(length: 120)]
    private ?string $name = null;

    #[Assert\NotBlank, Assert\Length(max: 140)]
    #[ORM\Column(length: 140)]
    private ?string $slug = null;

    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function setName(string $v): self { $this->name = $v; return $this; }
    public function getSlug(): ?string { return $this->slug; }
    public function setSlug(string $v): self { $this->slug = $v; return $this; }

    public function __toString(): string { return $this->name ?? ''; }
}

