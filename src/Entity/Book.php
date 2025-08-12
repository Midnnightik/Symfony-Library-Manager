<?php
// src/Entity/Book.php
namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[UniqueEntity('isbn')]
class Book
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank, Assert\Length(max: 200)]
    #[ORM\Column(length: 200)]
    private ?string $title = null;

    #[Assert\NotBlank, Assert\Length(max: 20)]
    #[ORM\Column(length: 20, unique: true)]
    private ?string $isbn = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $publishedAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $pages = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Author::class)]
    #[ORM\JoinTable(name: 'book_author')]
    private Collection $authors;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    // getters/setters ...
    public function getId(): ?int { return $this->id; }
    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $v): self { $this->title = $v; return $this; }
    public function getIsbn(): ?string { return $this->isbn; }
    public function setIsbn(string $v): self { $this->isbn = $v; return $this; }
    public function getPublishedAt(): ?\DateTimeImmutable { return $this->publishedAt; }
    public function setPublishedAt(?\DateTimeImmutable $v): self { $this->publishedAt = $v; return $this; }
    public function getPages(): ?int { return $this->pages; }
    public function setPages(?int $v): self { $this->pages = $v; return $this; }

    public function getCategory(): ?Category { return $this->category; }
    public function setCategory(?Category $v): self { $this->category = $v; return $this; }

    /** @return Collection<int, Author> */
    public function getAuthors(): Collection { return $this->authors; }
    public function addAuthor(Author $a): self { if(!$this->authors->contains($a)) $this->authors->add($a); return $this; }
    public function removeAuthor(Author $a): self { $this->authors->removeElement($a); return $this; }

    public function __toString(): string { return $this->title ?? ''; }
}

